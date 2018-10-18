package griffinbean.example.com.securepollmobile.Controller;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import griffinbean.example.com.securepollmobile.R;

public class HomePageActivityController extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.homepageactivity);
    }

    public void touchLogin(View view) {
        Intent intent = new Intent(this, LoginActivityController.class);
        startActivity(intent);
    }

    public void touchRegister(View view) {
        Intent intent = new Intent(this, RegisterActivityController.class);
        startActivity(intent);
    }
}

