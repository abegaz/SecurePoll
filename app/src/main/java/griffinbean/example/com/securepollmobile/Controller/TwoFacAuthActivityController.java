package griffinbean.example.com.securepollmobile.Controller;

import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import griffinbean.example.com.securepollmobile.R;

public class TwoFacAuthActivityController extends AppCompatActivity {
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.twofacauthactivity);
    }

    public void touchConfirm(View view) {
    }
}
