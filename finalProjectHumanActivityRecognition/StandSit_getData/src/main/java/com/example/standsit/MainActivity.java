package com.example.standsit;

import android.content.Intent;
import android.graphics.Color;
import android.hardware.SensorListener;
import android.hardware.SensorManager;
import android.os.Bundle;
import android.app.Activity;
import android.os.StrictMode;
import android.util.Log;
import android.view.Menu;
import android.view.View;
import android.view.WindowManager;
import android.widget.Button;
import android.widget.TextView;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.StatusLine;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.util.ArrayList;
import java.util.List;
import java.util.Timer;
import java.util.TimerTask;

public class MainActivity extends Activity implements SensorListener {

    final String tag = "IBMEyes";
    SensorManager sm = null;
    Button ssButton,regButton;
    TextView xView,yView,zView,oxView,oyView,ozView,sitView,jumpView;
    boolean status = false;
    Timer myTimer;

    int imax,imin,i;
    float bufferVal,dataX,max,min;

    String url = "http://thebear.efresh.in.th/finalproject/StandSit.php";
    //String url = "http://10.1.134.112:92/finalProject/StandSit.php";
    List<NameValuePair> params;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        getWindow().addFlags(WindowManager.LayoutParams.FLAG_KEEP_SCREEN_ON);

        if (android.os.Build.VERSION.SDK_INT > 9) {
            StrictMode.ThreadPolicy policy = new StrictMode.ThreadPolicy.Builder().permitAll().build();
            StrictMode.setThreadPolicy(policy);
        }

        sm = (SensorManager) getSystemService(SENSOR_SERVICE);
        //params = new ArrayList<NameValuePair>();

        imax = 0;
        imin = 0;
        i = 0;
        //bufferVal = new float[10];

        myTimer = new Timer();

        status = false;

        xView = (TextView) findViewById(R.id.xbox);
        yView = (TextView) findViewById(R.id.ybox);
        zView = (TextView) findViewById(R.id.zbox);

        oxView = (TextView) findViewById(R.id.OXbox);
        oyView = (TextView) findViewById(R.id.OYbox);
        ozView = (TextView) findViewById(R.id.OZbox);

        sitView = (TextView) findViewById(R.id.textViewSit);
        jumpView = (TextView) findViewById(R.id.textViewJump);

        regButton = (Button)findViewById(R.id.buttonReg);
        regButton.setOnClickListener(new View.OnClickListener() {
            public void onClick(View v) {
                Intent intent = new Intent(MainActivity.this, Register.class);
                startActivity(intent);
            }
        });

        ssButton = (Button)findViewById(R.id.ssButton);
        ssButton.setOnClickListener(new View.OnClickListener() {
            public void onClick(View v) {
                if(status){
                    ssButton.setBackgroundColor(Color.parseColor("#00FF00"));
                    status = false;
                    myTimer.cancel();
                    myTimer = new Timer();
                }
                else{
                    ssButton.setBackgroundColor(Color.parseColor("#FF0000"));
                    status = true;
                    myTimer.schedule(new TimerTask() {public void run() {timerTick();}}, 0, 250);
                }
            }
        });
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.main, menu);
        return true;
    }

    public void onSensorChanged(int sensor, float[] values) {
        synchronized (this) {
            //params = new ArrayList<NameValuePair>();

            if (sensor == SensorManager.SENSOR_ACCELEROMETER) {

                xView.setText("X: " + values[0]);
                yView.setText("Y: " + values[1]);
                zView.setText("Z: " + values[2]);

                //setBufferVal(values[0]);
                setDataX(values[0]);

                /*params = new ArrayList<NameValuePair>();
                params.add(new BasicNameValuePair("X", ""+values[0]));
                params.add(new BasicNameValuePair("Y", ""+values[1]));
                params.add(new BasicNameValuePair("Z", ""+values[2]));*/
            }

            /*if (sensor == SensorManager.SENSOR_ORIENTATION) {
                oxView.setText("OX: " + values[0]);
                oyView.setText("OY: " + values[1]);
                ozView.setText("OZ: " + values[2]);

                //params = new ArrayList<NameValuePair>();
                params.add(new BasicNameValuePair("OX", ""+values[0]));
                params.add(new BasicNameValuePair("OY", ""+values[1]));
                params.add(new BasicNameValuePair("OZ", ""+values[2]));
            }*/
        }
    }

    private void timerTick() {
        this.runOnUiThread(doTask);
    }

    private Runnable doTask = new Runnable() {
        public void run() {
            //String url = "http://10.0.2.2/FinalPro/StandSit.php";
            if(i < 10) {
                bufferVal = getDataX();

                if(i == 0)
                {
                    max = bufferVal;
                    min = bufferVal;
                    imax = i;
                    imin = i;
                }
                else if(max < bufferVal && i != 0)
                {
                    max = bufferVal;
                    imax = i;
                }
                else if(min > bufferVal && i != 0)
                {
                    min = bufferVal;
                    imin = i;
                }

                i++;
            }
            else {
                if(imax > imin)
                {
                    i = 1;//sit
                }
                else
                {
                    i = 2;//stand
                }

                params = new ArrayList<NameValuePair>();
                params.add(new BasicNameValuePair("X", ""+max));
                params.add(new BasicNameValuePair("Y", ""+min));
                params.add(new BasicNameValuePair("Z", ""+i));
                getHttpPost(url,params);
                i = 0;
            }
            //getHttpPost(url,params);
        }
    };

    public void onAccuracyChanged(int sensor, int accuracy) {
        Log.d(tag,"onAccuracyChanged: " + sensor + ", accuracy: " + accuracy);
    }

    protected void onResume() {
        super.onResume();
        // register this class as a listener for the orientation and accelerometer sensors
        sm.registerListener(this,
                SensorManager.SENSOR_ORIENTATION |SensorManager.SENSOR_ACCELEROMETER,
                SensorManager.SENSOR_DELAY_NORMAL);
    }

    protected void onStop() {
        sm.unregisterListener(this);
        super.onStop();
    }

    private void getHttpPost(String url, List<NameValuePair> params) {
        StringBuilder str = new StringBuilder();
        HttpClient client = new DefaultHttpClient();
        HttpPost httpPost = new HttpPost(url);

        try {
            httpPost.setEntity(new UrlEncodedFormEntity(params));
            HttpResponse response = client.execute(httpPost);
            StatusLine statusLine = response.getStatusLine();
            int statusCode = statusLine.getStatusCode();
            if (statusCode == 200) { // Status OK
                HttpEntity entity = response.getEntity();
                InputStream content = entity.getContent();
                BufferedReader reader = new BufferedReader(new InputStreamReader(content));
                String line;
                while ((line = reader.readLine()) != null) {
                    str.append(line);
                }
            } else {
                Log.e("Log", "Failed to download result..");
            }
        } catch (ClientProtocolException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
        }
    }
    private void setDataX(float value){
        dataX = value;
    }
    private float getDataX(){
        return  dataX;
    }
}
