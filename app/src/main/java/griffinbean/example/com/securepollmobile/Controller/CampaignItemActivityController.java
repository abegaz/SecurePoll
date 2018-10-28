package griffinbean.example.com.securepollmobile.Controller;

import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import griffinbean.example.com.securepollmobile.R;

public class CampaignItemActivityController extends AppCompatActivity {
    String [] UserInfo;
    String [] CampaignInfo;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.campaignitem);
        Bundle bundle = getIntent().getExtras();
        UserInfo = bundle.getStringArray("UserInfo");
        CampaignInfo = bundle.getStringArray("CampaignInfo");
    }
}