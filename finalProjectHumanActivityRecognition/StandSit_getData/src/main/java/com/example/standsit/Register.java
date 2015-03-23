package com.example.standsit;

import android.app.Activity;
import android.os.Bundle;
import android.os.StrictMode;
import android.util.Log;
import android.view.Menu;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.RadioButton;
import android.widget.Toast;

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
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.util.ArrayList;
import java.util.List;

public class Register extends Activity implements View.OnClickListener {

    Button submitButton, backButton;
    RadioButton MaleRadio, FemaleRadio;
    EditText txtAge, txtHigh, txtWeight;

    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.register);

        if (android.os.Build.VERSION.SDK_INT > 9) {
            StrictMode.ThreadPolicy policy = new StrictMode.ThreadPolicy.Builder().permitAll().build();
            StrictMode.setThreadPolicy(policy);
        }

        MaleRadio = (RadioButton)findViewById(R.id.radioButtonM);
        FemaleRadio = (RadioButton)findViewById(R.id.radioButtonFe);

        txtAge = (EditText)findViewById(R.id.editTextAge);
        txtHigh = (EditText)findViewById(R.id.editTextHigh);
        txtWeight = (EditText)findViewById(R.id.editTextWeight);

        submitButton = (Button)findViewById(R.id.submitButton);
        submitButton.setOnClickListener(this);
        backButton = (Button)findViewById(R.id.backButton);
        backButton.setOnClickListener(this);
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.main, menu);
        return true;
    }

    public void onClick(View v) {
        switch (v.getId()) {
            case R.id.submitButton: {
                String url = "http://thebear.efresh.in.th/finalproject/register.php";

                List<NameValuePair> params = new ArrayList<NameValuePair>();
                if(MaleRadio.isChecked())
                    params.add(new BasicNameValuePair("Sex", "Male"));
                else if(FemaleRadio.isChecked())
                    params.add(new BasicNameValuePair("Sex", "Female"));
                params.add(new BasicNameValuePair("Age", txtAge.getText().toString()));
                params.add(new BasicNameValuePair("High", txtHigh.getText().toString()));
                params.add(new BasicNameValuePair("Weight", txtWeight.getText().toString()));
                String resultServer  = getHttpPost(url,params);

                JSONObject c;
                try{
                    c = new JSONObject(resultServer);
                    if(c.getString("Status").equals(1))
                        Toast.makeText(Register.this, "Registered", Toast.LENGTH_SHORT).show();
                } catch (JSONException e) {
                    e.printStackTrace();
                }
                finish();
                break;
            }
            case R.id.backButton: {
                finish();
                break;
            }
        }
    }

    private String getHttpPost(String url, List<NameValuePair> params) {
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
        return str.toString();
    }
}

