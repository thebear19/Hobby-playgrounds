package com.example.rrc.app;

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

import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import java.util.Timer;
import java.util.TimerTask;

public class MainActivity extends Activity implements SensorListener {

    final String tag = "IBMEyes";
    SensorManager sm = null;
    Button ssButton;
    TextView xView;
    boolean status = false;
    Timer myTimer;

    int imax,imin,i;
    float bufferVal,dataX,max,min;

    String url = "http://thebear.efresh.in.th/finalproject/setActivity.php";
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
        i = 0;
        myTimer = new Timer();
        status = false;

        xView = (TextView) findViewById(R.id.xbox);

        ssButton = (Button)findViewById(R.id.ssButton);
        ssButton.setOnClickListener(new View.OnClickListener() {
            public void onClick(View v) {
                if(status){
                    ssButton.setBackgroundColor(Color.parseColor("#00FF00"));
                    ssButton.setText("START");
                    status = false;
                    myTimer.cancel();
                    myTimer = new Timer();
                }
                else{
                    ssButton.setBackgroundColor(Color.parseColor("#FF0000"));
                    ssButton.setText("STOP");
                    status = true;

                    params = new ArrayList<NameValuePair>();
                    params.add(new BasicNameValuePair("Max", "0"));
                    params.add(new BasicNameValuePair("Min", "0"));
                    params.add(new BasicNameValuePair("Index", "0"));
                    getHttpPost(url,params);

                    myTimer.schedule(new TimerTask() {public void run() {timerTick();}}, 0, 250);
                }
            }
        });
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.main, menu);
        return true;
    }

    public void onSensorChanged(int sensor, float[] values) {
        synchronized (this) {
            if (sensor == SensorManager.SENSOR_ACCELEROMETER) {

                xView.setText(""+values[0]);
                setDataX(values[0]);
            }
        }
    }

    private void timerTick() {
        this.runOnUiThread(doTask);
    }

    private Runnable doTask = new Runnable() {
        public void run() {
            if(i < 6) {
                bufferVal = getDataX();
                if(i == 0){
                    max = bufferVal;
                    min = bufferVal;
                    imax = i;
                    imin = i;
                }
                else if(max < bufferVal && i != 0){
                    max = bufferVal;
                    imax = i;
                }
                else if(min > bufferVal && i != 0){
                    min = bufferVal;
                    imin = i;
                }
                i++;
            }
            else {
                if(imax > imin){
                    i = 1;//sit
                }
                else{
                    i = 2;//stand
                }
                params = new ArrayList<NameValuePair>();
                params.add(new BasicNameValuePair("Max", ""+max));
                params.add(new BasicNameValuePair("Min", ""+min));
                params.add(new BasicNameValuePair("Index", ""+i));
                getHttpPost(url,params);
                i = 0;
            }
        }
    };

    public void onAccuracyChanged(int sensor, int accuracy) {
        Log.d(tag,"onAccuracyChanged: " + sensor + ", accuracy: " + accuracy);
    }

    protected void onResume() {
        super.onResume();
        sm.registerListener(this,
                SensorManager.SENSOR_ORIENTATION |SensorManager.SENSOR_ACCELEROMETER,
                SensorManager.SENSOR_DELAY_NORMAL);
    }

    protected void onStop() {
        sm.unregisterListener(this);
        super.onStop();
    }

    private void getHttpPost(String url, List<NameValuePair> params) {
        HttpClient client = new DefaultHttpClient();
        HttpPost httpPost = new HttpPost(url);

        try {
            httpPost.setEntity(new UrlEncodedFormEntity(params));
            HttpResponse response = client.execute(httpPost);
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
