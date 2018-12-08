package griffinbean.example.com.securepollmobile.Controller;

import android.app.NotificationChannel;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.content.Context;
import android.content.Intent;
import android.os.Build;
import android.os.Bundle;
import android.support.v4.app.NotificationCompat;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import com.google.firebase.database.*;
import griffinbean.example.com.securepollmobile.R;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Date;

public class HomePageActivityController extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        /**
         *  The block of code below sens a notification if the app finds a campaign that has ended, this
         *  is not an ideal notification, as it won't send outside of the app, but it's what we could implement in
         *  time allowed
         */
        DatabaseReference reference = FirebaseDatabase.getInstance().getReference();
        Query query = reference.child("CampaignData");
        query.addListenerForSingleValueEvent(new ValueEventListener() {
            @Override
            public void onDataChange(DataSnapshot dataSnapshot) {

                DateFormat df = new SimpleDateFormat("MM/dd/yyyy");
                Date cDate = new Date();
                String fDate = df.format(cDate);
                boolean oneOver = false;

                if (dataSnapshot.exists()) {
                    for (DataSnapshot CampaignData : dataSnapshot.getChildren()) {
                        if ((fDate.compareTo(CampaignData.child("EndDate").getValue().toString()) > 0)) {
                            oneOver = true;
                        }
                    }
                    if (oneOver == true) {
                        NotificationManager mNotificationManager;
                        NotificationCompat.Builder mBuilder = new NotificationCompat.Builder(getApplicationContext(), "notify_001");
                        Intent ii = new Intent(getApplicationContext(), LoginActivityController.class);
                        PendingIntent pendingIntent = PendingIntent.getActivity(getApplicationContext(), 0, ii, 0);
                        mBuilder.setContentIntent(pendingIntent);
                        mBuilder.setSmallIcon(R.mipmap.securepoll);
                        mBuilder.setContentTitle("SecurePoll");
                        mBuilder.setContentText("An Election has concluded! See if it was in your area!");
                        mBuilder.setAutoCancel(true);
                        mNotificationManager = (NotificationManager) getApplicationContext().getSystemService(Context.NOTIFICATION_SERVICE);
                        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O) {
                            String channelId = "YOUR_CHANNEL_ID";
                            NotificationChannel channel = new NotificationChannel(channelId,
                                    "Channel human readable title",
                                    NotificationManager.IMPORTANCE_DEFAULT);
                            mNotificationManager.createNotificationChannel(channel);
                            mBuilder.setChannelId(channelId);
                        }
                        mNotificationManager.notify(0, mBuilder.build());
                    }
                }
            }
            @Override
            public void onCancelled(DatabaseError databaseError) {
            }
        });

        super.onCreate(savedInstanceState);
        setContentView(R.layout.homepageactivity);
    }

    /**
     *  Sends to the login activity
     */
    public void touchLogin(View view) {
        Intent intent = new Intent(this, LoginActivityController.class);
        startActivity(intent);
    }

    /**
     *  Send to the register activity
     */
    public void touchRegister(View view) {
        Intent intent = new Intent(this, RegisterActivityController.class);
        startActivity(intent);
    }
}