
Overview

This plugin publishes a course link to a particular Facebook page. After create a course admin can add course_publish block in course page. Click "Login with Facebook" link and the course link "<moodlepath>/course/view.php?id=?<course id>" is published in particular page.
Using
Some setting is require for this Block to publish course link.
Setting Panel of block
App ID, Secret Key, Message, Caption, Picture, Pageaccesstoken, Pageid set by site admin.

Create a Facebook page

1. Go to facebook.com/pages/create.
2. Click to choose a Page category.
3. Select a more specific category from the dropdown menu and fill out the required information.
4. Click Get Started and follow the on-screen instructions.

Facebook Application Setting

Step 1: Goto https://developers.facebook.com/ > Login with you facebook account > Goto My Apps > Click Add a New app > Goto Facebook Canvas > Insert name of App > Choose category > Click create app id > Goto your created app
Step 2: Goto settings > Enter Namespace > Enter App Domains > Enter Contact Email > Click add platform > Select website > Enter Site URL > Save changes.
Step 3: Go To Status and review > Make this app visible to all.

Graph API Explorer Setting

Go To Tool & Support > Click on graph API Explorer > Select your app name from drop down list of graph API explorer > Copy Access token and paste it to "pageaccesstoken" field in block course_publish configuration page.
Uninstall

Admin can uninstall this admin tool from Site administration > Plugins >  Blocks > Manage Blocks



To install, place all files in /blocks/course_publish and visit /admin/index.php in your browser.

This block is written by Sandipa Mukherjee Dualcube <sandipa@dualcube.com>.
