# Usage
Use Laravel and AdminLte build data manage backend <br />
provider two login method and two login panel <br />
build in permission manage page using virtualorz/paemission <br />
build in personalize theme sessing <br />
build in CRUD control log <br /> 
suild in admin account CRUD method (if using local login)

# Install
    composer create-project --prefer-dist virtualorz/laraadmin PROJECT_NAME
    
# edit .env file
copy .env.example to .env and add this variables :

API_LOGIN_URL : url for admin remote login auth <br />
API_GETMEMBER_URL : url for remote get all admin member list after login <br />
LOGINSESSION : session key name for store admin login data <br />
LOGINSESSION_CUSTOMER : session key fir store customer login data <br />
LOGINPAGE : route name for admin lgoin path <br />
LOGINPAGE_CUSTOMER : route name for customer login path <br />
UPLOADDIR : file upload dir under public/upload/ <br />
SYSTEM_TITLE : text for web title <br />
SYSTEM_HEADER : html for left menu header , ex : "<b>COMPANY</b>SYSTEM_NAME" <br />
SYSTEM_HEADER_SHORT : html for left menu header short name , ex : "<b>J</b>PT" <br />
SYSTEM_FOOTER : html for footer , ex : "<div class='pull-right hidden-xs'><b>Version</b> 2.4.0</div><strong>Copyright &copy; 2014-2016 <a href='https://adminlte.io'>Almsaeed Studio</a>.</strong> All rights reserved." <br />
LOGIN_PATH : login method, 'remote' for remote login , 'local' for local login <br />
LOGIN_TITLE : text for login view title <br />
LOGIN_VIEW : login view style, 'custom' for front page login style, 'admin' for AdminLte defualt login view <br />
FILESYSTEM_DRIVER : use in config/filesystem, defult use : public <br />
