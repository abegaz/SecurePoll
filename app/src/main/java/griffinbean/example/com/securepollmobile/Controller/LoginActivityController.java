package griffinbean.example.com.securepollmobile.Controller;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import griffinbean.example.com.securepollmobile.R;

public class LoginActivityController extends AppCompatActivity
{

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.loginactivity);
    }

    public void touchLogin(View view) {
        Intent intent = new Intent(this, RaceListActivityController.class);
        startActivity(intent);
    }
}

