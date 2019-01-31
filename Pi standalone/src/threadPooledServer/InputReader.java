package threadPooledServer;

import resources.Settings;
import resources.ExecutorServices;

import java.io.BufferedReader;
import java.io.IOException;
import java.util.HashMap;
import java.util.Map;
import java.util.concurrent.ScheduledFuture;

/**
 * Created by Lenovo T420 on 17-1-2018.
 */
public class InputReader implements Runnable {
    private BufferedReader bufferedReader = null;
    private Map<Integer, MessageContainer> messages = new HashMap<>();
    private ScheduledFuture<?> scheduledFuture = null;

    private int stationCounter = 0;
    private int activeStation;
    private String stringBuffer;
    private int lineCounter = -1;
    private int messageCounter = 0;
    private Boolean newFile = false;

    private Boolean stopped = false;

    long start = 0;
    long s1 = 0;
    long s2 = 0;
    long s3 = 0;
    long s4 = 0;
    long t;

    private int day = -1;
    private int minute = -1;
    private int hour = -1;
    private MessageContainer activeStationObj;

    InputReader(BufferedReader bufferedReader) {
        this.bufferedReader = bufferedReader;
    }

    public void setScheduledFuture(ScheduledFuture<?> scheduledFuture){this.scheduledFuture=scheduledFuture;}

    public void run() {
        try {
            String inputLine;
            if ((inputLine = bufferedReader.readLine()) != null) {
                //System.out.println(inputLine);
                handleMessage(inputLine);
            }else{
                System.out.println("lost connection");
                stop();
            }
        } catch (IOException e) {
            stop();
            System.out.println("Exception caught when trying to listen on port "
                    + "xxx" + " or listening for a connection");
            System.out.println(e.getMessage());
        } catch (Exception e) {
            throw e;
        }
    }

    private void handleMessage (String inputLine) {
        if (inputLine.contains("<MEASUREMENT>")) {
            stringBuffer = "";
            lineCounter = 0;
        }

        if (lineCounter > 0 && lineCounter < 15) {
            substringInputLine(inputLine, lineCounter);
        }
        if (inputLine.contains("</MEASUREMENT>")) {
            stringBuffer = "";
            lineCounter = 15;
        }
        if (inputLine.contains("</WEATHERDATA>")) {
            messageCounter++;
            if (this.newFile) newFile();
        }
        lineCounter++;
    }

    private void newFile(){
        new FileCreator(this.messages, messageCounter);
        messages = new HashMap<>();
        stationCounter = 0;
        this.newFile = false;
        messageCounter = 0;
    }
    private void substringInputLine(String inputLine, int x) {
        inputLine = inputLine.trim();
        boolean doWrite = true;
        switch(x) {
            case 0:
                break;
            case 1: //STN
                int station;
                stringBuffer = inputLine;
                station = Integer.parseInt(inputLine.substring(5, inputLine.length() - 6));
                this.activeStation = station;
                stringBuffer = inputLine;
                if (stationCounter!=10) {
                    MessageContainer messageContainer = new MessageContainer();
                    messageContainer.setStation((this.activeStation));
                    messages.put(station, messageContainer);
                    this.activeStationObj = messageContainer;
                    stationCounter++;
                } else {
                    this.activeStationObj = messages.get(this.activeStation);
                    activeStationObj.setNewmssg(true);

                }
                break;
            case 2: //Date
                String inputLine2;
                inputLine2 = inputLine;

                inputLine = inputLine.substring(6);
                stringBuffer = inputLine.substring(0, inputLine.length() - 7);
                activeStationObj.setMsgDate(stringBuffer);
                checkDate(stringBuffer);
                stringBuffer = inputLine2;
                break;
            case 3: //Time
                String inputLine3;
                inputLine3 = inputLine;

                inputLine = inputLine.substring(6);
                stringBuffer = inputLine.substring(0, inputLine.length() - 7);
                activeStationObj.setMsgTime(stringBuffer);
                stringBuffer = stringBuffer.substring(0, 5);
                checkTime(stringBuffer);
                stringBuffer = inputLine3;
                break;
            case 4: //TEMP
                stringBuffer = inputLine;
                break;
            case 5: //DEWP
                inputLine = inputLine.substring(6);
                stringBuffer = inputLine.substring(0, inputLine.length() - 7);
                while(stringBuffer.length()<5){stringBuffer+=" ";}
                doWrite = false;
                break;
            case 6: case 7: //STP-SLP
                inputLine = inputLine.substring(5);
                stringBuffer = inputLine.substring(0, inputLine.length() - 6);
                while(stringBuffer.length()<6){stringBuffer+=" ";}
                doWrite = false;
                break;
            case 8: //VISIB
                inputLine = inputLine.substring(7);
                stringBuffer = inputLine.substring(0, inputLine.length() - 8);
                while(stringBuffer.length()<5){stringBuffer+=" ";}
                doWrite = false;
                break;
            case 9:case 10: //WDSP-PRCP
                stringBuffer = inputLine;
                break;
            case 11: //SNDP
                doWrite = false;
                break;
            case 12: //FRSHTT
                stringBuffer = inputLine;
                break;
            case 13: //CLDC
                inputLine = inputLine.substring(6);
                stringBuffer = inputLine.substring(0, inputLine.length() - 7);
                while(stringBuffer.length()<4){stringBuffer+=" ";}
                doWrite = false;
                break;
            case 14: //WNDDIR
                stringBuffer = inputLine;
                break;
        }
        if (doWrite) {
            if (stringBuffer.isEmpty()) {
                stringBuffer = "0.00";
            }
            activeStationObj.addMessage(stringBuffer);
        }
        stringBuffer = "";
    }

    private void checkDate(String date) {
        int day = Integer.parseInt(date.substring(5, 7));
        if(day==-1){this.day = day;}
        if (this.day != day) {
            newFile = true;
            this.day = day;
        }
    }

    private void checkTime(String time) {
        int minute = Integer.parseInt(time.substring(3, 5));
        int hour = Integer.parseInt(time.substring(0, 2));
        if(minute==-1){this.minute =minute; this.hour = hour;}
        if (minute - this.minute > Settings.FileSettings.FILE_INTERVAL - 1 || hour != this.hour) {
            this.newFile = true;
            this.minute = minute;
            this.hour = hour;
        }
    }

    private void stop() {
        if (!stopped) {
            stopped = true;
            this.scheduledFuture.cancel(false);
            ExecutorServices.connections--;

            if (!ThreadPooledServerRunner.isRunning) {
                ThreadPooledServerRunner.isRunning = true;
                new Thread(ThreadPooledServerRunner.server).start();
            }
        }
    }
}

