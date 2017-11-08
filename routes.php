
<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

  Route::group(['middleware' => ['web']], function () {
    Route::get('/', 'AngularController@serveApp');
    Route::get('/unsupported-browser', 'AngularController@unsupported');
    Route::get('user/verify/{verificationCode}', ['uses' => 'Auth\AuthController@verifyUserEmail']);
    Route::get('auth/{provider}', ['uses' => 'Auth\AuthController@redirectToProvider']);
    Route::get('auth/{provider}/callback', ['uses' => 'Auth\AuthController@handleProviderCallback']);
    Route::get('/api/authenticate/user', 'Auth\AuthController@getAuthenticatedUser');
    //Route::get('subcourse/Instructeurs{verificationCode}', ['uses' => 'Auth\AuthController@verifyUserEmail']);
});

  $api->group(['middleware' => ['api']], function ($api) {
    $api->controller('auth', 'Auth\AuthController');

    // Password Reset Routes...
    $api->post('auth/password/email', 'Auth\PasswordResetController@sendResetLinkEmail');
    $api->get('auth/password/verify', 'Auth\PasswordResetController@verify');
    $api->post('auth/password/reset', 'Auth\PasswordResetController@reset');
});

  $api->group(['middleware' => ['api', 'api.auth']], function ($api) {
    $api->get('users/me', 'UserController@getMe');
    $api->put('users/me', 'UserController@putMe');
    $api->post('/profileedit', ['uses' => 'UserController@putMe', 'as' => 'profileedit.ajax']);

    // Contact Us Page
    $api->post('contactus', 'ContactusController@create');
    $api->get('websitecontactus/{sid}', 'ContactusController@contactusbywebsite');
    $api->post('/contactusedit', ['uses' => 'ContactusController@update', 'as' => 'contactusedit.ajax']);

    // Home Page Management - create
    $api->post('homepageslider', 'HomepageSlider@Create');
    $api->post('homepagevideo', 'HomepagevideoController@Create');
    $api->post('homepageaddress', 'HomepageaddressController@Create');
    $api->post('Homepagecerti', 'HomepagecertiController@Create');
    $api->post('homepageservices', 'HomepageServiceController@Create');

    // Home Page Management - get By website
    $api->get('gethomeslider/{sid}', 'HomepageSlider@gethomesliderbywebsite');
    $api->get('gethomeservices/{sid}', 'HomepageServiceController@getservicesbywebsite');
    $api->get('gethomevideo/{sid}', 'HomepagevideoController@getvideeobywebsite');
    $api->get('gethomeaddress/{sid}', 'HomepageaddressController@getaddressbywebsite');
    $api->get('gethomecertification/{sid}', 'HomepagecertiController@getcertificatbywebsite');

    // Get data by Id
    $api->get('getsliderbyId/{sid}', 'HomepageSlider@getsliderbyId');
    $api->get('getservicebyId/{sid}', 'HomepageServiceController@getservicesbyId');
    $api->get('getcertibyId/{sid}', 'HomepagecertiController@getcertibyId');

    // Home Page Management - Delete
    $api->delete('homepageslider/delete/{sid}', 'HomepageSlider@sliderdelete');
    $api->delete('homepageservices/delete/{sid}', 'HomepageServiceController@delete');
    $api->delete('homepagecerti/delete/{sid}', 'HomepagecertiController@delete');

    // Home Page Management - Edit
    //$api->put('/homeslideredit', 'HomepageSlider@sliderupdate');  
    $api->post('/homeslideredit', ['uses' => 'HomepageSlider@sliderupdate', 'as' => 'homeslideredit.ajax']);
    $api->post('/homeserviceedit', ['uses' => 'HomepageServiceController@update', 'as' => 'homeserviceedit.ajax']);
    $api->post('/homepagevideoedit', ['uses' => 'HomepagevideoController@update', 'as' => 'homepagevideoedit.ajax']);
    $api->post('/homepageaddressedit', ['uses' => 'HomepageaddressController@update', 'as' => 'homepageaddressedit.ajax']);
    $api->post('/homepagecertiedit', ['uses' => 'HomepagecertiController@update', 'as' => 'homepagecertiedit.ajax']);

    // PMC home page manage
    $api->post('pmchomepagemanag', 'pmchomepageController@create');
    $api->get('getpmchometape', 'pmchomepageController@getpmchometape');
    $api->delete('pmchomepageetap/delete/{sid}', 'pmchomepageController@delete');
    $api->get('getetapebyId/{sid}', 'pmchomepageController@getetapebyId');
    $api->post('/pmcetapedit', ['uses' => 'pmchomepageController@update', 'as' => 'pmcetapedit.ajax']);

    // PMC home page en berf manage
    $api->post('pmchomepageenbref', 'PmcEnbrefController@create');
    $api->get('getpmchomeenbref', 'PmcEnbrefController@getpmchomeenbref');
    $api->delete('pmchomepageenbref/delete/{sid}', 'PmcEnbrefController@delete');
    $api->get('getenbrefbyId/{sid}', 'PmcEnbrefController@getenbrefbyId');
    $api->post('/pmcenbrefedit', ['uses' => 'PmcEnbrefController@update', 'as' => 'pmcenbrefedit.ajax']);

    // PMC home page Contact map manage
    $api->post('pmchomepagecontact', 'PmcContactController@create');
    $api->post('pmcuploadcontactImage', 'PmcContactController@createImage');
    $api->get('getpmchomecontact', 'PmcContactController@getpmchomecontact');
    $api->get('gethomecontact/{sid}', 'PmcContactController@gethomecontact');
    $api->delete('pmchomepagecontact/delete/{sid}', 'PmcContactController@delete');
    $api->get('getcontactbyId/{sid}', 'PmcContactController@getcontactbyId');
    $api->post('/pmccontactedit', ['uses' => 'PmcContactController@update', 'as' => 'pmccontactedit.ajax']);

    // ESSR single page manage
    $api->post('essrsignlepage', 'EssrSinglePageController@create');
    $api->get('getessrsignlepage/{sid}', 'EssrSinglePageController@get');
    $api->get('getessrparentpage/{sid}', 'EssrSinglePageController@getParent');
    $api->delete('essrsignlepage/delete/{sid}', 'EssrSinglePageController@delete');
    $api->get('essrsignlepagebyId/{sid}', 'EssrSinglePageController@getbyId');
    $api->post('/essrsignlepageedit', ['uses' => 'EssrSinglePageController@update', 'as' => 'pmcenbrefedit.ajax']);

    // ESSR Bloge manage
    $api->post('essrBlog', 'EssrBlogController@create');
    $api->get('getessrBlog/{sid}', 'EssrBlogController@get');
    $api->delete('essrBlog/delete/{sid}', 'EssrBlogController@delete');
    $api->get('essrBlogbyId/{sid}', 'EssrBlogController@getbyId');
    $api->post('/essrBlogedit', ['uses' => 'EssrBlogController@update', 'as' => 'essrBlogedit.ajax']);

    // ESSR Testimonial manage
    $api->post('essrTestimonial', 'EssrTestimonialController@create');
    $api->get('getessrTestimonial/{sid}', 'EssrTestimonialController@get');
    $api->delete('essrTestimonial/delete/{sid}', 'EssrTestimonialController@delete');
    $api->get('essrTestimonialbyId/{sid}', 'EssrTestimonialController@getbyId');
    $api->post('/essrTestimonialedit', ['uses' => 'EssrTestimonialController@update', 'as' => 'essrTestimonialedit.ajax']);

    // ESSR Header Footer manage
    $api->post('essrHeaderFooter', 'EssrHeaderFooterController@create');
    $api->get('getHeaderFooter/{sid}', 'EssrHeaderFooterController@get');
    $api->delete('essrHeaderFooter/delete/{sid}', 'EssrHeaderFooterController@delete');
    $api->get('headerFooterbyId/{sid}', 'EssrHeaderFooterController@getbyId');
    $api->post('/essrHeaderFooteredit', ['uses' => 'EssrHeaderFooterController@update', 'as' => 'essrHeaderFooteredit.ajax']);

    // Essr Home Page Slider
    // Website SEO Manage
    $api->post('websiteseo', 'WebsiteSeoController@create');
    $api->get('getseobysite/{sid}', 'WebsiteSeoController@getseobywebsite');

    /* Student Contracts Controller */
    $api->get('getStudentBysubscribId/{sid}', 'CustomerController@getCustomerbyInscriptionId');
    $api->post('createStudentContract', 'studentcontractController@create');
    $api->get('getContractBysubscribId/{sid}', 'studentcontractController@getContractByInscriptionId');
    $api->post('/editStudentContract', ['uses' => 'studentcontractController@update', 'as' => 'editStudentContract.ajax']);
    $api->post('/updateStudentStatus', ['uses' => 'CustomerController@updateStudentStatus', 'as' => 'updateStudentStatus.ajax']);
    $api->get('getsubcoursebymaincourseEtat/{etat}', 'SubcourseController@getSubcoursesbyMaincourseandEtat');
    $api->get('/searchStudentContract/{getdata}', 'studentcontractController@searchContract');

    // Website page manage
    $api->post('websitecoursepage', 'EssrCoursepageController@create');
    $api->get('getwebsitecoursepage/{cpid}', 'EssrCoursepageController@get');
    $api->get('getcoursepageparentpage/{cpid}', 'EssrCoursepageController@getParent');
    $api->delete('websitecoursepage/delete/{cpid}', 'EssrCoursepageController@delete');
    $api->get('websitecoursepagebyId/{cpid}', 'EssrCoursepageController@getbyId');
    $api->post('/websitecoursepageedit', ['uses' => 'EssrCoursepageController@update', 'as' => 'pmcenbrefedit.ajax']);

    /* Feedback Controller */
    $api->get('getmaincourseforfeedback', 'MaincourseController@getIndexWithActiveStatus');
    $api->get('getsubcourseforfeedback/{maincourseId}', 'SubcourseController@getsubcoursesbymaincourseAll');
    $api->post('courseFeedback', 'FeedbackController@create');
    $api->get('getInstructorFeedback', 'FeedbackController@getFeedbackByInstructor');
    $api->get('getStudentFeedback', 'FeedbackController@getFeedbackByStudent');
    $api->get('getFeedbackbyId/{fid}', 'FeedbackController@getbyId');
    $api->get('deletedfeedbackinstuctor', 'FeedbackController@deletedfeedbackinstuctor');
    $api->get('deletedfeedbackstudent', 'FeedbackController@deletedfeedbackstudent');
    $api->get('recoverfeedback/{feedbackid}', 'FeedbackController@recoverfeedback');
    $api->delete('courseFeedback/delete/{fid}', 'FeedbackController@delete');
    $api->delete('courseFeedback/deletearchive/{fid}', 'FeedbackController@deletearchive');
    $api->post('/courseFeedbackEdit', ['uses' => 'FeedbackController@update', 'as' => 'courseFeedbackEdit.ajax']);

    /* ---------------------------- */
    /* Alumni */
    /* ---------------------------- */
    /* Alumni Inivtation */
    $api->post('alumniInvitationCreate', 'alumniInvitationController@create');
    $api->get('getInvitation', 'alumniInvitationController@get');
    $api->delete('alumniInvitation/delete/{pid}', 'alumniInvitationController@delete');
    /* ---------------------------- */
    /* ---------------------------- */
    /* ---------------------------- */

    // website module
    $api->post('website', 'WebsiteController@Create');
    $api->get('websites', 'WebsiteController@getIndex');
    $api->get('deletedwebsites', 'WebsiteController@getdeletedIndex');
    $api->get('activewebsites', 'WebsiteController@getIndexWithActiveStatus');
    $api->get('website-edit/{websiteId}', 'WebsiteController@getwebsite');
    $api->get('recoverwebsite/{websiteId}', 'WebsiteController@recover');
    $api->put('website-edit', 'WebsiteController@put');
    $api->delete('website/delete/{websiteId}', 'WebsiteController@delete');
    $api->post('website/deletes', 'WebsiteController@deletes');



    //meta category modeule
    $api->get('tbleventviewmeta/{metaid}', 'MetaCategoryController@tbleventviewmeta');
    $api->post('meta-category','MetaCategoryController@Create');
    $api->get('metacategories', 'MetaCategoryController@getIndex');
    $api->delete('metacat/archive/{metacatId}', 'MetaCategoryController@Archive');
    $api->delete('metacourscategoty/harddelete/{id}', 'MetaCategoryController@harddelete');
    $api->post('metacat/deletes', 'MetaCategoryController@deletes');
    $api->get('metacat-edit/{metacatId}', 'MetaCategoryController@getmetacat');
    $api->put('metacat-edit', 'MetaCategoryController@put');
    $api->get('metacat-edit/{metacatId}', 'MetaCategoryController@getmaincourse');
    $api->get('deletedmetacat', 'MetaCategoryController@getdeletedIndex');
    $api->get('recovermetacat/{metacatId}', 'MetaCategoryController@recover');
    $api->get('activemetacat', 'MetaCategoryController@getIndexWithActiveStatus');
    $api->get('activemetacourseswithoutwebsiteid', 'MetaCategoryController@getactivemetacourseswithoutwebsiteid');
    $api->get('activemetacatbywebsiteid/{websiteId}', 'MetaCategoryController@getactivemetacatbywebsiteid');
    $api->get('activemetacatbywebsiteiddescription/{websiteId}', 'MetaCategoryController@getmetacatWithwebsiteIddescription');
    $api->get('metacategoryActive', 'MetaCategoryController@getIndexWithActiveStatusmeta');



    // maincourse module
    $api->get('tbleventviewmain/{mainid}', 'MaincourseController@tbleventviewmain');
    $api->post('maincourse', 'MaincourseController@Create');
    $api->get('maincourses', 'MaincourseController@getIndex');
    $api->get('listmetaandmaincourses', 'MaincourseController@listmetaandmaincourses');
    $api->get('activemaincourses', 'MaincourseController@getIndexWithActiveStatus');
    $api->get('activemaincourses/{metaid}', 'MaincourseController@getmaincoursewithmetaid');
    $api->get('activemetacats', 'MetaCategoryController@getIndexWithActiveStatus');

    // $api->get('activemaincoursesbywebsiteid/{websiteId}', 'MaincourseController@getmaincourseWithwebsiteId');
    $api->get('activemaincoursesbymetacat/{websiteId}', 'MaincourseController@getactivemaincoursesbymetacat');
    
    $api->get('activemaincoursesbywebsiteiddescription/{websiteId}', 'MaincourseController@getmaincourseWithwebsiteIddescription');
    $api->get('activemaincourseswithoutmetacatid', 'MaincourseController@getactivemaincourseswithoutmetacatid');

    $api->get('maincourse-view/{maincourseId}', 'MaincourseController@getmaincourseView');
    $api->get('maincourse-edit/{maincourseId}', 'MaincourseController@getmaincourse');
    $api->put('maincourse-edit', 'MaincourseController@put');
    $api->delete('maincourse/delete/{maincourseId}', 'MaincourseController@delete');
    $api->delete('maincourse/archive/{maincourseId}', 'MaincourseController@Archive');
    $api->post('maincourse/deletes', 'MaincourseController@deletes');
    $api->get('deletedmaincourse', 'MaincourseController@getdeletedIndex');
    $api->get('recovermaincourse/{maincourseId}', 'MaincourseController@recovercourse');
    $api->delete('maincourse/harddelete/{maincourseId}', 'MaincourseController@harddelete');
    // Place module
    $api->post('place', 'PlaceController@Create');
    $api->get('places', 'PlaceController@getIndex');
    $api->get('activeplaces', 'PlaceController@getIndexWithActiveStatus');
    $api->get('place-edit/{placeId}', 'PlaceController@getplace');
    $api->put('place-edit', 'PlaceController@put');
    $api->delete('place/delete/{placeId}', 'PlaceController@delete'); 
    $api->delete('place/harddelete/{placeId}', 'PlaceController@harddelete'); 
    $api->post('place/deletes', 'PlaceController@deletes');
    $api->get('deletedplace', 'PlaceController@getdeletedIndex');
    $api->get('recoverplace/{placeId}', 'PlaceController@recover');
    
    // notice module
    $api->post('notice', 'CreatenoticeController@postnotice');
    $api->get('notice', 'CreatenoticeController@notice');

    $api->delete('notice/delete/{noticeId}', 'CreatenoticeController@delete');
    $api->delete('notice/harddelete/{noticeId}', 'CreatenoticeController@harddelete');
    $api->post('notice/deletes', 'CreatenoticeController@deletes');

    $api->get('deletednotice', 'CreatenoticeController@getdeletedIndex');
    $api->get('recovernotice/{noticeId}', 'CreatenoticeController@recover');

    $api->get('notice-edit/{noticeId}', 'CreatenoticeController@getnotice');
    $api->get('noticearchiveview', 'CreatenoticeController@noticearchiveview');
    $api->put('notice-edit', 'CreatenoticeController@put');

    //Instructor module
    $api->post('instructor', 'instructorController@create');
    // $api->get('instructors','instructorController@getall');
    //Alert
    $api->get('/alert', ['uses' => 'AlertController@getIndex', 'as' => 'alert.ajax']);
    $api->get('/customeralert', ['uses' => 'AlertController@getCustomer', 'as', 'customeralert.ajax']);

    $api->get('/CustomerStatus6', ['uses' => 'AlertController@CustomerStatus6', 'as', 'CustomerStatus6.ajax']);
    $api->get('/CustomerExamPass', ['uses' => 'AlertController@CustomerExamPass', 'as', 'CustomerExamPass.ajax']);
    $api->get('/CronStatusAlert', ['uses' => 'AlertController@CronStatusAlert', 'as', 'CronStatusAlert.ajax']);
    $api->get('/CronStudentStatusAlert', ['uses' => 'AlertController@CronStudentStatusAlert', 'as', 
        'CronStudentStatusAlert.ajax']);

    $api->get('/redAlert', ['uses' => 'AlertController@getredAlert', 'as', 'redAlert.ajax']);
    $api->get('/birthdate', ['uses' => 'AlertController@getbirthdate', 'as', 'birthdate.ajax']);
    $api->get('/newCours', ['uses' => 'AlertController@getNewCours', 'as', 'newCours.ajax']);
    $api->get('/coursbegin', ['uses' => 'AlertController@getCoursBegin', 'as', 'coursbegin.ajax']);
    $api->get('/CoursStudent', ['uses' => 'AlertController@getCoursStudent', 'as', 'CoursStudent.ajax']);
    $api->get('/Instructeursview', 'AlertController@getInstructeursview');
    $api->get('/Noinstructeursview', 'AlertController@getNoinstructeursview');
    $api->get('/instructeursnoreplay', 'AlertController@getinstructeursnoreplay');

    $api->get('/instructornextxourse', ['uses' => 'AlertController@instructornextxourse', 'as', 'instructornextxourse.ajax']);
    $api->post('instuct-admin-permission', 'AlertController@getInstuctadminpermission');

    $api->get('/alert', ['uses' => 'AlertController@getIndex', 'as' => 'alert.ajax']);
    $api->get('/customeralert', ['uses' => 'AlertController@getCustomer', 'as', 'customeralert.ajax']);
    $api->get('/CustomerStatus', ['uses' => 'AlertController@CustomerStatus', 'as', 'CustomerStatus.ajax']);
    $api->get('/CustomerStatus6', ['uses' => 'AlertController@CustomerStatus6', 'as', 'CustomerStatus6.ajax']);
    $api->get('/CustomerExamPass', ['uses' => 'AlertController@CustomerExamPass', 'as', 'CustomerExamPass.ajax']);
    $api->get('/CronStatusAlert', ['uses' => 'AlertController@CronStatusAlert', 'as', 'CronStatusAlert.ajax']);
    $api->get('/CronStudentStatusAlert', ['uses' => 'AlertController@CronStudentStatusAlert', 'as', 'CronStudentStatusAlert.ajax']);

    $api->get('/redAlert', ['uses' => 'AlertController@getredAlert', 'as', 'redAlert.ajax']);
    $api->get('/birthdate', ['uses' => 'AlertController@getbirthdate', 'as', 'birthdate.ajax']);
    $api->get('/newCours', ['uses' => 'AlertController@getNewCours', 'as', 'newCours.ajax']);
    $api->get('/coursbegin', ['uses' => 'AlertController@getCoursBegin', 'as', 'coursbegin.ajax']);
    // $api->get('/coursbegin','AlertController@getCoursBegin');

    $api->get('/CoursStudent', ['uses' => 'AlertController@getCoursStudent', 'as', 'CoursStudent.ajax']);
    $api->get('/Instructeursview', 'AlertController@getInstructeursview');
    $api->get('/Noinstructeursview', 'AlertController@getNoinstructeursview');
    $api->get('/instructeursnoreplay', 'AlertController@getinstructeursnoreplay');

    $api->get('/instructornextxourse', ['uses' => 'AlertController@instructornextxourse', 'as', 'instructornextxourse.ajax']);
    $api->post('instuct-admin-permission', 'AlertController@getInstuctadminpermission');

    // HandNote module
    $api->post('handnote', 'HandnotesController@Create');
    $api->get('handnotes', 'HandnotesController@getIndex');
    $api->get('handnote-edit/{handnoteId}', 'HandnotesController@gethandnote');
    $api->get('handnote/{CustomerId}', 'HandnotesController@gethandnotewithuser');
    $api->put('handnote-edit', 'HandnotesController@put');
    $api->delete('handnote/archive/{handnoteId}', 'HandnotesController@handnotearchive');
    $api->delete('handnote/delete/{handnoteId}', 'HandnotesController@delete');
    $api->post('handnote/deletes', 'HandnotesController@deletes');
    $api->get('deletedhandnote', 'HandnotesController@getdeletedhandnotes');
    $api->get('recoverhandnote/{websiteId}', 'HandnotesController@recoverhandnote');

    // EmailTemplate
    // $api->post('emailtemplate', 'EmailTemplateController@create');
    // $api->post('emailtemplate', 'EmailTemplateController@create');

    $api->post('/emailtemplate',['uses' => 'EmailTemplateController@create', 'as' => 'emailtemplate.ajax']);





    $api->get('emailtemplates', 'EmailTemplateController@getIndex');
    $api->delete('emailtemplate/delete/{TemplateId}', 'EmailTemplateController@delete');
    $api->delete('emailtemplate/harddelete/{TemplateId}', 'EmailTemplateController@harddelete');
    $api->get('emailtemplate-edit/{TemplateId}', 'EmailTemplateController@getemailtemplate');
    $api->post('/emailtemplate-edit-put',['uses' => 'EmailTemplateController@put', 'as' => 'emailtemplate-edit-put.ajax']);



    $api->post('emailtemplate/deletes', 'EmailTemplateController@deletes');
    $api->put('emailtemplate-edit', 'EmailTemplateController@put');
    $api->get('deletedemailtemplate', 'EmailTemplateController@getdeleteemailtemplates');
    $api->get('recoveremailtemplate/{TemplateId}', 'EmailTemplateController@recovertemplate');

    //Events
    $api->post('events', 'EventsController@Create');
    // $api->get('events', 'EventsController@getIndex');
    $api->get('upcomingevent', 'EventsController@upcomingevent');
    $api->get('events-edit/{eventsId}', 'EventsController@getevent'); 
    $api->put('events-edit', 'EventsController@put');
    $api->delete('events/delete/{eventsId}', 'EventsController@delete');
    $api->delete('events/deletearchive/{eventsId}', 'EventsController@deletearchive');
    $api->post('events/deletes', 'EventsController@deletes');
    $api->get('deletedevents', 'EventsController@getdeletedevents');
    $api->get('recoverevents/{eventsId}', 'EventsController@recoverevents');
    $api->get('events', 'EventsController@getIndex');
    // Customer module

    $api->post('customerverify', 'CustomerController@verify');
    $api->get('deletedcustomer', 'CustomerController@getdeletedIndex');
    $api->get('recovercustomer/{customerId}', 'CustomerController@recover');
    $api->delete('customer/harddelete/{cid}', 'CustomerController@harddelete');
    
    // $api->get('Customerdisplaywebsitewise/{websiteid}', 'CustomerController@Customerdisplaywebsitewise');
    $api->post('customer', 'CustomerController@Create');
    $api->get('customers', 'CustomerController@getIndex');
    $api->get('customerscourswise/{subcourseId}', 'CustomerController@getIndexwithsubcourseId');
    $api->get('customerscourswiseemail/{subcourseId}', 'CustomerController@getIndexwithsubcourseIdEmail');
    // $api->get('liststudentsubscription', 'CustomerController@getliststudentsubscription');
    $api->get('searchstudentsubscription', 'CustomerController@searchstudentsubscription');

    $api->post('/composecustomermail', ['uses' => 'EmailsController@customercreate', 'as' => 'composecustomermail.ajax']);
    $api->get('customerscourswisenotinmoodle/{subcourseId}', 'CustomerController@getIndexwithsubcourseIdnotinmoodle');
    //$api->get('activecustomer', 'CustomerController@getIndexWithActiveStatus');
    $api->get('customer-edit/{customerId}', 'CustomerController@getcustomer');
    $api->put('customer-edit', 'CustomerController@put');
    $api->delete('customer/delete/{customerId}', 'CustomerController@delete');
    $api->get('studentsubscriptions/{CustomerId}', 'CustomerController@getsubscriptionwithcustomerId');
    $api->get('subscription-edit/{subscriptionId}', 'CustomerController@getsubscription');
    $api->put('subscription-edit', 'CustomerController@putsubscription');
    $api->post('customer/deletes', 'CustomerController@deletes');
    $api->get('customerlog/{CustomerId}', 'historyController@customerlog');
    $api->delete('customerlog/delete/{LogId}', 'historyController@delete');
    $api->delete('customeremaillog/delete/{LogEmailId}', 'EmailsController@custlogdelete');

    //Moodle
    //$api->get('getdatass/{subscriptionId}', 'MoodleaccessController@getIndex');
    $api->post('moodle', 'MoodleaccessController@multipleaccess');

    //Moodle courswise
    $api->get('moodlemaincours', 'MoodlecoursewiseController@getIndex');
    $api->get('getsubcoursefrommainid/{maincourseId}', 'MoodlecoursewiseController@getsubcoursefrommainid');
    $api->get('getusersfromcoursid/{coursId}', 'MoodlecoursewiseController@getusersfromcoursid');
    $api->post('enrolusercourswise', 'MoodlecoursewiseController@enrolusercourswise');

    //Moodle user wise
    // $api->get('moodleregusers', 'MoodleaccessController@moodleregusers');
    $api->post('examstatuschange', 'MoodleaccessController@examstatuschange');
    $api->get('getusersfromid/{userId}', 'MoodleaccessController@getusersfromid');
    $api->get('moodleregcourse/{userId}', 'MoodleuserwiseController@moodleregcourse');
    //$api->get('moodleregsubcourse/{courseId}', 'MoodleuserwiseController@moodleregsubcourse');
    $api->get('getsubcoursefrommainidwithuser/{userId}/{maincourseId}', 'MoodleuserwiseController@getsubcoursefrommainidwithuser');
    $api->post('enroluseruserswise', 'MoodleuserwiseController@enroluseruserswise');
    $api->post('onclickaccess', 'MoodleuserwiseController@onclickaccess');
    $api->post('onclickrevokeaccess', 'MoodleuserwiseController@onclickrevokeaccess');

    //Instructeurs  moodle
    
    $api->get('moderatorroleusers', 'InstructeursController@moderatorroleusers');
    $api->get('instructeursroleusers', 'InstructeursController@instructeursroleusers');
    $api->get('instructeursroleusersforlist', 'InstructeursController@instructeursroleusersforlist');
    $api->get('Insfrommoodle/{userId}', 'InstructeursController@Insfrommoodle');
    $api->post('instomoodleenroll', 'InstructeursController@instomoodleenroll');
    $api->post('onclickrevokeaccessinst', 'InstructeursController@onclickrevokeaccessinst');


    // Odt module 
    $api->post('odt', 'OdtController@Create');
    $api->get('odtview/{id}', 'OdtController@ViewOdt');
    $api->get('ODTcustomerlog/{CustomerId}', 'OdtController@Odtcustomerlog');
    $api->get('odts', 'OdtController@getIndex');
    $api->get('courseodts/{subcourseId}', 'OdtController@courseodts');

    $api->get('activeodtsmain/{maincourse}', 'OdtController@getactiveodtsmain');
    $api->get('activeodt', 'OdtController@getIndexWithActiveStatus');
    $api->get('activeodts/{metaid}', 'OdtController@getactiveodtwithcourseid');
    $api->get('activeodtsforgroup/{subcoursId}', 'OdtController@getactiveodtwithcourseidforgroup');
    $api->get('activeodtsmeta', 'OdtController@getactiveodtsmeta');

    $api->get('odt-edit/{odtId}', 'OdtController@getodt');
    $api->post('odt/deletes', 'OdtController@deletes');
    //$api->put('odt-edit','OdtController@put'); 
    $api->delete('odt/harddelete/{odtId}', 'OdtController@harddelete');
    $api->delete('odt/delete/{odtId}', 'OdtController@delete');
    $api->delete('odt/archive/{odtId}', 'OdtController@Archive');
    $api->post('/odtedit', ['uses' => 'OdtController@put', 'as' => 'odtedit.ajax']);
    $api->post('/odtdataadd', ['uses' => 'OdtController@odtdataadd', 'as' => 'odtdataadd.ajax']);
    $api->get('deletedodt', 'OdtController@getdeletedIndex');
    $api->get('recoverodt/{odtId}', 'OdtController@recoverodt');


    //Generate Odt

    $api->get('generateodt/{OdtId}/{StudId}', 'GenerateDocsController@generateodt');
    $api->get('generateodtgroup/{OdtId}/{subcourseidtag}', 'GenerateDocsController@generateodtgroup');
    $api->get('generatepreviewodt/{OdtId}', 'GenerateDocsController@generatepreviewodt');


    //Import/Export Module
    $api->post('export-csv', 'ImportExportController@exportcsv');
    $api->post('/import-csv', ['uses' => 'ImportExportController@importcsv', 'as' => 'import-csv.ajax']);


    // Webmail module
    $api->post('/composemail', ['uses' => 'EmailsController@create', 'as' => 'composemail.ajax']);
    $api->get('emailtemplates', 'EmailTemplateController@getIndex');

    //alert
    $api->get('/alert', ['uses' => 'AlertController@getIndex', 'as' => 'alert.ajax']);

    //cronsystem 
    
    $api->get('cronsystemlistmaincourse/{mainid}', 'CronsystemController@cronsystemlistmaincourse');
    $api->get('recovercron/{croneid}', 'CronsystemController@recover');
    $api->post('cronsystem', 'CronsystemController@Create');
    $api->get('cronsystemlistwithmeta/{metaid}', 'CronsystemController@cronsystemlistwithmeta');
    $api->get('cronsystemlist', 'CronsystemController@getcronsystemlist');
    $api->get('cronsystemlistarchive', 'CronsystemController@getcronsystemlistarchive');
    $api->get('viewcron/{cronId}', 'CronsystemController@getIndexwithcronId');
    $api->get('cronsystem-edit/{cronId}', 'CronsystemController@getCronDetail');
    $api->PUT('cronsystem-edit', 'CronsystemController@getPUT');
    $api->post('cronsystem/archiveAll', 'CronsystemController@archiveAll');
    $api->get('cronsystem-view/{cronId}', 'CronsystemController@getCronDetail');
    $api->delete('cronsystem/delete/{subcourseId}', 'CronsystemController@delete');
    $api->delete('cronsystem/archive/{subcourseId}', 'CronsystemController@archive');

    //reading mail 
    $api->get('/mailbox', ['uses' => 'MailboxController@ReadMailBox', 'as' => 'mailbox.ajax']);
    $api->get('/mailboxinbox', ['uses' => 'MailboxController@ReadInboxmail', 'as' => 'mailboxinbox.ajax']);
    $api->get('/mailboxUnread', ['uses' => 'MailboxController@ReadUnread', 'as' => 'mailboxUnread.ajax']);
    $api->get('/mailboxsent', ['uses' => 'MailboxController@ReadSentmail', 'as' => 'mailboxsent.ajax']);
    $api->get('/mailboxdraft', ['uses' => 'MailboxController@ReadDraftmail', 'as' => 'mailboxdraft.ajax']);
    $api->get('/mailboxspam', ['uses' => 'MailboxController@ReadSpammail', 'as' => 'mailboxspam.ajax']);
    $api->get('/mailboxtrash', ['uses' => 'MailboxController@ReadTrashmail', 'as' => 'mailboxtrash.ajax']);
    $api->get('/mailboxjunk', ['uses' => 'MailboxController@ReadJunkmail', 'as' => 'mailboxjunk.ajax']);
    $api->get('mailboxinboxfetchbody/{MsgId}/{FolderName}', 'MailboxController@ReadInboxMailBody');
    $api->get('mailboxinboxfetchbodysent/{MsgId}/{FolderName}', 
        'MailboxController@ReadInboxMailBodySent');
    $api->delete('trashmail/recover/{Msgno}', 'MailboxController@trashmailrecover'); 

    $api->post('mailboxinboxdelete/{MsgId}/{FolderName}', 'MailboxController@ReadInboxMailBodyDelete');
    $api->post('mailboxinboxdeleteall', 'MailboxController@maildeletemultiple');
    $api->get('subcourseslist/{subcourseId}', 'EmailsController@subcourseslist');
    $api->get('studlist/{studId}', 'EmailsController@studentList');
    $api->get('/mailboxall/{FolderName}', 'MailboxController@ReadMailBoxAll');
    $api->get('/emailtemplate', ['uses' => 'EmailsController@template', 'as' => 'emailtemplate.ajax']);

    //Access Emails of user
    // $api->get('emailaccess/{Id}','MailboxController@AccessEmail');
    $api->get('emailaccess/{Id}', 'AdminAccessEmailController@GetUser');
    $api->get('/adminmailbox/{Id}', 'AdminAccessEmailController@ReadMailBox');
    $api->get('/adminmailboxall/{Id}/{FolderName}', 'AdminAccessEmailController@ReadMailBoxAll');
    $api->get('adminmailboxinboxfetchbody/{Id}/{MsgId}/{FolderName}', 'AdminAccessEmailController@AdminReadInboxMailBody');
    $api->post('adminmailboxinboxdelete/{Id}/{MsgId}/{FolderName}', 'AdminAccessEmailController@ReadInboxMailBodyDelete');
    $api->get('emalsmscustomerlog/{Id}', 'EmailsController@emalsmscustomerlog');

    //SMS module
    $api->post('sms', 'SMSController@sendsms');
    $api->get('smstemplate', 'SMSController@smstemplate');


    //Stats Module
    $api->get('statssinglecourscustomerlist/{subcoursId}', 'StatsController@getstatssinglecourscustomerlist');
    $api->get('comapreCategory/{CateCompareFrom}/{YearCompareFrom}/{CateCompareTo}/{YearCompareTo}', 'StatsController@comapreCategory');
    $api->get('ComapreCoursExamSuccessRation/{CoursFrom}', 'StatsController@getComapreCoursExamSuccessRation');
    $api->get('ComapreCoursFeedBackScore/{CoursfeedbackFrom}', 'StatsController@getComapreCoursFeedBackScore');
    $api->get('GetSubcours/{CategoryFrom}', 'StatsController@getCategoryFrom');


    //subcourse module
    
    $api->get('subcoursetblevent/{subcourseId}', 'SubcourseController@getsubcoursetblevent');
    $api->get('cronsystemlistwithmaincourse/{mainid}', 'SubcourseController@cronsystemlistwithmaincourse');
    Route::get('subcourse/Instructeurs/{id}', 'SubcourseController@Instructeursmail');
    $api->post('subcourse', 'SubcourseController@Create');
    $api->post('subcourse/statuschange', 'SubcourseController@coursestatuschange');
    //$api->get('activesubcourses', 'SubcourseController@getIndexWithActiveStatus');
    // $api->get('subcourses', 'SubcourseController@getIndex');
    $api->get('subcoursescalender/{name}', 'SubcourseController@getIndexcalender');
    // $api->get('upcomingcoursewithinsc', 'SubcourseController@upcomingcoursewithinsc');
    $api->get('subcourse-edit/{subcourseId}', 'SubcourseController@getsubcourse');
    $api->get('tbleventview/{subcourseId}', 'SubcourseController@tbleventview');
    $api->get('activesubcoursesbymaincourse/{metaid}', 'SubcourseController@getactivesubcoursesbymaincourse');
    $api->get('activesubcoursesbymaincoursearchive/{maincourseId}', 'SubcourseController@activesubcoursesbymaincoursearchive');
    $api->get('activesubcoursesbymaincourseAll/{maincourseId}', 'SubcourseController@getactivesubcoursesbymaincourseAll');
    //$api->put('subcourse-edit','SubcourseController@put'); 
    $api->delete('subcourse/harddelete/{subcourseId}', 'SubcourseController@harddelete');
    $api->delete('subcourse/delete/{subcourseId}', 'SubcourseController@delete');
    $api->post('subcourse/deletes', 'SubcourseController@deletes');
    $api->delete('subcourse/archive/{subcourseId}', 'SubcourseController@archive');
    $api->post('/subcourseedit', ['uses' => 'SubcourseController@put', 'as' => 'subcourseedit.ajax']);
    $api->post('fileedit/{Id}', 'MultipleImageController@filedelete');
    $api->post('/subcoursedataadd', ['uses' => 'SubcourseController@subcoursedataadd', 'as' => 'subcoursedataadd.ajax']);
    $api->get('deletedsubcourse', 'SubcourseController@getdeletedIndex');
    $api->get('recoversubcourse/{subcourseId}', 'SubcourseController@recoversubcourse');
    //  $api->post('/subcoursedataaddimage',['uses' => 'SubcourseController@subcoursedataaddimage', 'as' => 'subcoursedataaddimage.ajax']);
    //MultiImage module
    $api->get('getMultiImage/{subcourseId}', 'MultipleImageController@getIndexwithSubcourseId');
    // $api->post('/Multiimage',['uses'=>'MultipleImageController@avtardelete','as'=>'Multiimage.ajax']);
    $api->get('filess/{MultiimageId}', 'MultipleImageController@delete');
    //    $api->post('/fileedit',['uses'=>'MultipleImageController@filedelete','as'=>'fileedit.ajax']);
});

$api->group(['middleware' => ['api', 'api.auth', 'role:Admin']], function ($api) {

    //user module
    $api->controller('users', 'UserController');
    // $api->get('instructorss','InstructeursController@gatall');

    $api->post('/useradd', ['uses' => 'UserController@userdataadd', 'as' => 'useradd.ajax']);
    $api->post('/useredit', ['uses' => 'UserController@putShow', 'as' => 'useredit.ajax']);
    $api->post('/avtaredit', ['uses' => 'UserController@avtardelete', 'as' => 'avtaredit.ajax']);
    $api->get('archive/{userId}', 'UserController@archiveuser');
    $api->get('/archiveuserlist','UserController@archiveuserlist');
    $api->get('recoveruser/{userId}', 'UserController@recoveruser');
    $api->delete('user/harddelete/{userid}', 'UserController@harddelete');
    $api->post('rolesadd', 'UserController@postRoles');
    
    //email history
    $api->controller('emails', 'EmailsController');
    $api->get('emailhistorydelete/{Id}', 'EmailsController@EmailHistoryDelete');

    //History 
    $api->get('/history', 'historyController@getall');
    $api->get('historydelete/{historyId}', 'historyController@delete');
    $api->get('historyData/{historyId}', 'historyController@gethistory');
    $api->post('history/deletes', 'historyController@deletes');
    $api->post('CustomerEmailSMSLog/custlogdeletes', 'EmailsController@custlogdeletes');

    //Bugreport
    $api->get('bugreportlist', 'BugreportController@getbugreport');
    $api->get('bugreportlistarchive', 'BugreportController@getbugreportarchive');
    $api->post('createbug', 'BugreportController@Create');
    $api->post('bugreport/archiveAll', 'BugreportController@archiveAll');
    $api->get('activedeveloper', 'BugreportController@getActivedeveloper');
    $api->get('bugrecordedit/{bugid}', 'BugreportController@getbugDetail');
    $api->get('bug-view/{bugid}', 'BugreportController@getbugDetail');
    $api->post('/bugedit', 'BugreportController@putedit');
    $api->delete('bug/delete/{bugid}', 'BugreportController@bugdelete');
    $api->delete('bug/bugarchive/{bugid}', 'BugreportController@archive');
    $api->get('recoverbugreport/{bugid}', 'BugreportController@bugreportrecover');
});

//$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {
//$api->group(['middleware' => ['api', 'api.auth']], function ($api) {
    $api->get('subcourses', ['as' => 'subcourses.index', 'uses' => 'SubcourseController@getIndex']);

    $api->get('/places', ['uses' => 'PlaceController@getIndex', 'as' => 'alert.ajax']);
    $api->get('/subcourses', ['uses' => 'SubcourseController@getIndex', 'as' => 'subcourses.ajax']);
    $api->get('/upcomingcoursewithinsc', ['uses' => 'SubcourseController@upcomingcoursewithinsc', 'as' => 'upcomingcoursewithinsc.ajax']);
    $api->get('/events', ['uses' => 'EventsController@getIndex', 'as' => 'events.ajax']);
    $api->get('/Customerdisplaywebsitewise/{websiteid}', ['uses' => 'CustomerController@Customerdisplaywebsitewise', 'as' => 'Customerdisplaywebsitewise.ajax']);
    // $api->get('liststudentsubscription', 'CustomerController@getliststudentsubscription');
    $api->get('/liststudentsubscription', ['uses' => 'CustomerController@getliststudentsubscription', 'as' => 'liststudentsubscription.ajax']);
    // $api->get('moodleregusers', 'MoodleaccessController@moodleregusers');
    $api->get('/moodleregusers', ['uses' => 'MoodleaccessController@moodleregusers', 'as' => 'moodleregusers.ajax']);

    // $api->get('Customerdisplaywebsitewise/{websiteid}', 'CustomerController@Customerdisplaywebsitewise');
});

Route::get('moodlerpermissionanatomy', 'MoodleaccessController@moodlerpermissionanatomy');
Route::get('moodlerpermissionFSM', 'MoodleaccessController@moodlerpermissionFSM');
Route::get('moodlerpermissionpathology', 'MoodleaccessController@moodlerpermissionpathology');


