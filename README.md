# BibleClubWebsite
This will include all the html/css/js/php/sql for your first web-development application for your Monday Night Bible Group Sessions.
The learning objective of this project is to get familiar with vanilla JS, HTML, CSS, and SQL.

Learning Outcomes for Next Project:
1. Think before programming, this project has too much unnessary and nested divs.
2. Think of using frameworks, they reduce code and the amount of debugging time.
3. Think of a very good naming convention for elements and get used to copy and pasting variables where needed instead of on memorization (reduces debugging time).
4. Do not inject workflow with JS but link documents to JS.
5. Limit comments in document (code should be self-explanatory). Small comments in classes/functions. Big comments prior to classes/functions. Largest comments on top of each document.
6. Get better with GitHub, think of a better way to push updates.
7. Always try to fix with plain CSS before overriding with JS.

## Updated by Kenneth on Thursday April 14, 2022

- Finished Login Form.
- Added login support.
- Added sign-out support.
- Change loading-welcome class' text.

## Updated by Kenneth on Sunday April 17, 2022 (Easter Sunday 🥚 Thank You Jesus!)

- Added a page to create posts, edit posts, and delete posts (usig AJAX and PHP).
- Adjusted the element height for the div to edit post and delete post.
- Fixed the previous navbar since hidden menu expanded under the elements for posts in main (adjusted z-index).
- Added a "about-me" page for users to type info in. 

## Updated by Kenneth on Monday April 18, 2022
- Added about us page, where all information submitted in about-me page are displayed.
- Fixed "about-me" page form since the form would not submit since PHP though periods in form text where string concatenations.


NEED TO: 
- Make posts actually visible when user click on a post div.
- Finish about us page.
- Make admin panel for admin users to create users.
- Change CSS for mobile + tablet users, disable scroll lock JS.


Current File Structure of Project as of April 21, 2022
```
📦 Monday_Night_Bible_Study
| 📜 htaaccess  
| 📜 aboutus.php   
| 📜 bible.php  
| 📜 index.php  
| 📜 manageaccount.php  
| 📜 managepost.php    
| 📜 texteditor.php    
| 📜 adminpanel.php    
|      
└─── 📂assets
|    └─── 📂css
|    |    | ...
|    |
|    └─── 📂images
|    |    | ...
|    |
|    └─── 📂js
|         | ...
|
└─── 📂config
|    |  📜 config.php
|
└─── 📂includes
|    └─── 📂form_handlers
|    |    |  📜 login_handler.php
|    |
|    └─── 📂handlers
|    |    |  📜 deletePost.php
|    |    |  📜 logout.php
|    |    |  📜 pictureupload.php
|    |
|    └─── 📂headers
|    |    |  📜 guestheaderpost.php
|    |    |  📜 userheader.php
|    |    |  📜 userheaderpost.php
|    |    |  📜 guestheader.php
|    |
|    └─── 📂post part
|    |    | 📜 post_part_header.php
|    |    | 📜 post_part_footer.php
|    |
|    |  📜 head.php
|    
└─── 📂posts
| ...
 ```
## Updated by Kenneth on April 22, 2022
- Fixed Navbar on Bible.php (Contents overlapped Menu).
- Fixed ManagePost form so it can now post things.
- Fixed Navbar Links on Login Form (Since it was Calling Header Which Was Designed To Link Things From Index).
- Manageposts now creates a new file for posts.
- Delete post in manageposts uses AJAX to delete post from database and also unlink post from file directory.
- Fixed Bible.php (text), used ReGeX to add line breaks in by chapter. The ReGeX expression was: 
- Finished Image Upload in ManageAccount.php, user can now add images to database and updated to aboutus.php

NEED TO: 
- Make admin panel for admin users to create users.
- Change CSS for mobile + tablet users, disable scroll lock JS.
- Finish Image Upload And Posts for Uploading Images for Post Div on Index as Well as Uploading Images for The Actual Post When User Clicks on Post.

## Updated by Kenneth on April 29, 2022
- Added support for line-breaks in manageposts.php.
- Added option to mark posts as private in manageposts.php.
- Whenever a post is uploaded, the number of posts from the author now increases.
- Whenever a post is deleted via AJAX, the number of posts from the author now decreases.
- Added a <meta> tag to the login form so that all it's elements is adjusted for mobile devices.
- ManagePosts.php JQuery hides all divs on small devices and prompts users to write posts on desktops + laptsops only.
- Added an admin panel.
- Post pages are adjusted for mobile devices.

NEED TO:
- Finish admin panel to register user, delete user, and push out an alert.

## Updated by Kenneth on April 30, 2022
- Adjusted adminpanel.php for mobile users.
- Added register user on admin panel.
- Added delete user on admin panel.
- Styled admin panel.
- Added option to push alert out to the group.

NEED TO:
- Display push out alerts.
- Include additional file to admin panel for admin users.
- Add a column to know if users uploaded their own profile pictures or not (and if not) upload a random default picture for them.
- Unlink post files when user deletes them.

## Updated by Kenneth on May 17, 2022
- Fixed navigation bar on bible.php for mobile users.
- Fixed navigation bar on manageaccount.php for mobile users.
- Centered text on manageaccount.php for mobile users.
- Wrote some more HTML elements along to handle a the fetch from a new API call that retreives weather in manageaccount.php. (Previous one was just a custom built div and offered very little customaziation).
- Added headers for admin users so that admin panel now appears on navigation bar if user is an admin.
- Added random pictures for user accounts upon creation in adminpanel.php, which appears appropriately in aboutus.php and manageaccount.php.
- Added date join for user accounts upon creation in adminpanel.php.
- Parsed date retrieved from database and displayed the date the user joined in aboutus.php correctly.
- Added image retrieval and name retrieval for admin user in adminpanel.php.

NEED TO:
- Make another php page to update/edit existing posts.
- Display pictures for the user appropriately from posts.
- Add a bit of a margin under adminpanel.php.
- Display alerts (again).
- Make every page secured from non-users and non-admin.
- Add explanation for adminpanel.php.

## Updated by Kenneth on May 18, 2022
- Display pictures on post page according to the article of the post.
- Add a text-editor .php page to update post using the ?= in the URL for links.
- Added explanation on admin panel.
- Secured every site where user is needed and secured every site where admin is needed.

REMOVED:
- Deleted token for both API on manageaccount.php.
- Removed URL of where database was hosted as well as DB and other stuff on adminpanel.php.
- Remove server contents on config.php.
