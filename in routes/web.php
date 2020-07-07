<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
 
/* ContactUSController controller*/
Route::get('/contact', 'ContactUSController@contact')
    ->name('contact');

Route::post('/contact', 'ContactUSController@contactStore')
    ->name('contact.store');

Route::post('/contact/destroy', 'ContactUSController@contactDestroy')
    ->name('contact.destroy');
    
// Auth::routes(['verify' => true]); or Auth::routes(); 
Auth::routes();

Route::get('/dashboard', 'HomeController@index')
    ->name('dashboard');
    //->middleware('verified');

/* user route message*/
Route::get('/user/inbox', 'HomeController@inbox')
    ->name('user.message.inbox');
Route::get('/inbox/message/show/{id}', 'HomeController@userMessageShow')
    ->name('user.message.show');
Route::post('/user/message/markasdelete', 'HomeController@userMessagemarkAsDelete')
    ->name('user.message.markasdelete');

// user_send_messages
Route::get('/send-messages/create', 'HomeController@sendCreate')
    ->name('user.send.message.create');
Route::get('/send-messages', 'HomeController@send')
    ->name('user.send.messages');
Route::post('/send-messages/store', 'HomeController@sendMessageStore')
    ->name('user.send.message.store');
Route::get('/send-messages/show/{id}', 'HomeController@sendShow')
    ->name('user.send.message.show');
Route::post('/send-messages/destroy/selected', 'HomeController@destroySelectUserSendMessage')
    ->name('send.messages.destroy.selected');

/* user notifications */
Route::get('/notifications', 'HomeController@notifications')
    ->name('user.notifications');
Route::get('/notification/{id}', 'HomeController@notificationShow')
    ->name('user.notification.show'); 
Route::post('/notification/delete/selected', 'HomeController@destroySelectNotification')
    ->name('user.notification.delete.selected');
    
/* notifications message-views*/ 
Route::get('/well-come/user_id={id}', 'HomeController@wellComeMessage')
    ->name('user.wellcome');

/* post comment user dashboad*/ 
Route::get('/user-dash/postcomments', 'HomeController@userPostCommentsall')
    ->name('user.dash.post.comments'); 
        
/* if role permission "change_password" User can change password*/
Route::get('/user/password', 'HomeController@password')
    ->name('user.password')
    ->middleware('can:change_password');

Route::put('/user/password', 'HomeController@changePassword')
    ->name('user.change.password')
    ->middleware('can:change_password');

/* if role permission "update_profile" User can update profile*/
Route::get('/profile/{id}','profileController@show')
    ->name('profile.show')
    ->middleware('can:update_profile');
    
/* if role permission "update_profile" User can update profile*/
Route::put('/profile/update/{id}','profileController@update')
    ->name('profile.update')
    ->middleware('can:update_profile');

/* if role permission "preview_profile" User can preview profile*/
Route::get('/profile/preview/{id}','profileController@preview')
    ->name('user.preview');
    // ->middleware('can:preview_profile');
Route::get('/image/gallery-preview/{id}','profileController@galleryPreview')
    ->name('user.image.gallery.preview');

/* user image gallery */    
Route::get('/user-gallery/{id}', 'profileController@userGalleryAll')
    ->name('user.gallery.all');
Route::get('/user-gallery-image/upload', 'profileController@imageGalleryCreate')
    ->name('restaurant.user.gallery.image.create');
Route::post('/user-gallery-image/upload', 'profileController@imageGalleryStore')
    ->name('restaurant.user.gallery.image.store');
Route::post('user-gallery/destroy', 'profileController@destroyGalleries')
    ->name('user.gallery.destroy');
Route::delete('user-gallery/destroy/{id}', 'profileController@destroyGalleryOne')
    ->name('user.gallery.destroy.one');
 

Route::prefix('admin')->group( function() { // ->middleware('auth:admin')
    
    Route::get('/register', 'Auth\AdminRegisterController@showRegistationFrom')
        ->name('admin.register.form');
    Route::post('/register', 'Auth\AdminRegisterController@create')
        ->name('admin.register');

    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')
        ->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')
        ->name('admin.login.submit');
    Route::get('/logout', 'Auth\AdminLoginController@logout')
        ->name('admin.logout');

    Route::get('/', 'AdminController@index')
        ->name('admin.dashboard');
            
    Route::post('/password/email','Auth\AdminForgotPasswordController@sendResetLinkEmail')
        ->name('admin.password.email');
    Route::get('/password/reset','Auth\AdminForgotPasswordController@showLinkRequestForm')
        ->name('admin.password.request');
    Route::post('/password/reset','Auth\AdminResetPasswordController@reset');
    Route::get('/password/reset/{token}','Auth\AdminResetPasswordController@showResetForm')
        ->name('admin.password.reset');

    // inbox
    Route::get('/inbox', 'AdminController@inbox')
        ->name('admin.message.inbox');
    Route::get('/send', 'AdminController@send')
        ->name('admin.message.send');
    Route::get('/message/{id}', 'AdminController@messageShow')
        ->name('admin.message.view');

    // admin_send_messages
    Route::get('/reply/user_id={user_id}', 'AdminController@messageReplyView')
            ->name('admin.message.reply.veiw');
    Route::post('/reply', 'AdminController@messageReply')
            ->name('admin.message.reply');
    Route::get('/reply/{id}', 'AdminController@replyShow')
            ->name('admin.message.reply.show');
    Route::post('/reply/delete/selected', 'AdminController@destroyReply')
            ->name('admin.message.reply.delete.selected');

    // users messages
    Route::get('/user/messages', 'AdminController@userMsg')
        ->name('admin.user.messages');
    Route::get('/user/message/{id}', 'AdminController@userMsgShow')
        ->name('admin.user.message.show');
    Route::post('/user/message/delete', 'AdminController@destroyuserAndReplyMsg')
        ->name('admin.user.reply.destroy');
        
    // tags
    Route::get('/tags', 'AdminController@tags')
        ->name('admin.all.tags');
    Route::post('/tag/create', 'AdminController@tagCreate')
        ->name('admin.tag.store');
    Route::delete('/tag/destroy/{id}', 'AdminController@tagDestroy')
        ->name('admin.tag.destroy');

    //  adminNotifications 
    Route::get('/notifications', 'AdminController@adminNotifications')
        ->name('admin.notifications'); 
    Route::get('/notification/{id}', 'AdminController@adminNotificationShow')
        ->name('admin.notification.show'); 
    Route::delete('/notification/delete/{id}', 'AdminController@destroyNotification') // not use
        ->name('admin.notification.delete');
    Route::post('/notification/delete/selected', 'AdminController@destroySelectNotification')
        ->name('admin.notification.delete.selected'); 
     
    // admin settings     
    Route::get('/settings', 'AdminSettingController@index')
    ->name('admin.settings');
    Route::post('/settings', 'AdminSettingController@store')
        ->name('admin.settings.store'); 

    // MenuController
    Route::get('menus', 'MenuController@index')
        ->name('admin.menu.all');
    Route::get('menu/create', 'MenuController@create')
        ->name('admin.menu.create');
    Route::post('menu/store', 'MenuController@store')
        ->name('admin.menu.store');
    Route::get('menu/show/{id}', 'MenuController@show')
        ->name('admin.menu.show');
    Route::get('menu/{id}/edit', 'MenuController@edit')
        ->name('admin.menu.edit');
    Route::put('menu/{id}/update', 'MenuController@update')
        ->name('admin.menu.update');
    Route::post('menu/destroy', 'MenuController@destroy')
        ->name('menu.destroy');
    // MenuController menus Search
    Route::any('/search/menus','MenuController@menuSearch')
        ->name('admin.menus.search');

    // MenuItemController
    Route::get('menu-item/create/{id}', 'MenuItemController@create')
        ->name('admin.menu.item.create');
    Route::post('menu-item/store', 'MenuItemController@store')
        ->name('admin.menu.item.store');
    Route::get('menu-item/all', 'MenuItemController@index')
        ->name('admin.menu.item.all');
    Route::get('menu-item/{id}/edit', 'MenuItemController@edit')
        ->name('admin.menu.item.edit');
    Route::put('menu-item/{id}/edit', 'MenuItemController@update')
        ->name('admin.menu.item.update');
    Route::post('menu-item/destroy', 'MenuItemController@destroy')
        ->name('admin.menu.item.destroy');
    Route::delete('menu-item/destroy/{id}', 'MenuItemController@destroyOne')
        ->name('admin.menu.item.destroy.one');

    // MenuItemController menu-items Search
    Route::any('/search/menu-items','MenuItemController@menuItemSearch')
        ->name('admin.menu.item.search');
    Route::post('menu-item/tag/detach', 'MenuItemController@tagDetach')
        ->name('admin.menu.item.tag.detach');

    Route::get('open-hourses/all', 'OpenHourseController@index')
        ->name('admin.open.hourses.all');
    Route::get('open-hourses/create', 'OpenHourseController@create')
        ->name('admin.open.hourses.create');
    Route::post('open-hourses/store', 'OpenHourseController@store')
        ->name('admin.open.hourses.store');
    Route::get('open-hourses/{id}/edit', 'OpenHourseController@edit')
        ->name('admin.open.hourses.edit');
    Route::put('open-hourses/{id}/update', 'OpenHourseController@update')
        ->name('admin.open.hourses.update');
    Route::post('open-hourses/destroy', 'OpenHourseController@destroy')
        ->name('admin.open.hourses.destroy');
    Route::delete('open-hourses/destroy/{id}', 'OpenHourseController@destroyOne')
        ->name('admin.open.hourses.destroy.one');
 
    Route::get('gallery/{menu_id}/all', 'GalleryController@index')
        ->name('admin.gallery.all');
    Route::get('gallery/create', 'GalleryController@create')
        ->name('admin.gallery.create'); 
    Route::post('gallery/store', 'GalleryController@store')
        ->name('admin.gallery.store');
    Route::get('gallery/{id}/edit', 'GalleryController@edit')
        ->name('admin.gallery.edit');
    Route::put('gallery/{id}/update', 'GalleryController@update')
        ->name('admin.gallery.update'); 
    Route::post('gallery/destroy', 'GalleryController@destroy')
        ->name('admin.gallery.destroy');
    Route::delete('gallery/destroy/{id}', 'GalleryController@destroyOne')
        ->name('admin.gallery.destroy.one');
    Route::put('gallery/{id}/add-to/image-slider', 'GalleryController@addToImageSlider')
        ->name('admin.gallery.add.image.slider');  
    Route::put('gallery/{id}/remove-from/image-slider', 'GalleryController@removeformImageSlider')
        ->name('admin.gallery.remove.image.slider');
    // GalleryController slider images Search
    Route::any('/search/gallery-images','GalleryController@gallerySearch')
        ->name('admin.gallery.images.search'); 
        
    // LocationController
    Route::get('location/all', 'LocationController@index')
        ->name('admin.location.all');
    Route::get('location/create', 'LocationController@create')
        ->name('admin.location.create'); 
    Route::post('location/store', 'LocationController@store')
        ->name('admin.location.store'); 
    Route::get('location/{id}/edit', 'LocationController@edit')
        ->name('admin.location.edit');
    Route::put('location/{id}/update', 'LocationController@update')
        ->name('admin.location.update');
    Route::post('location/destroy', 'LocationController@destroy')
        ->name('admin.location.destroy');
    Route::delete('location/destroy/{id}', 'LocationController@destroyOne')
        ->name('admin.location.destroy.one');

    //memberPosts
    Route::get('/member/posts', 'AdminController@memberPosts')
        ->name('admin.member.posts');
    Route::get('/posts-catagory/all', 'AdminController@postsCatagory')
        ->name('admin.posts.catagory.all');
    Route::delete('/posts-catagory/destroy/{id}', 'AdminController@catagoryDestroy')
        ->name('admin.catagory.destroy'); 
    Route::post('/member/posts/destroy', 'AdminController@memberPostdestroy')
        ->name('admin.member.posts.destroy'); 
    Route::post('/search/users','AdminController@memberPostSearch')
        ->name('admin.posts.search'); 

    //app documention route
    Route::view('/documention-about', 'admin.site-documention.about')->name('documention.about');
    Route::view('/documention-installation', 'admin.site-documention.installation')->name('documention.installation');
    Route::view('/documention-admin', 'admin.site-documention.admin')->name('documention.admin');
    Route::view('/documention-user', 'admin.site-documention.user')->name('documention.user');
    Route::view('/documention-user-profile', 'admin.site-documention.user-profile')->name('documention.user.profile');
    Route::view('/documention-peges', 'admin.site-documention.front-page')->name('documention.peges');
    Route::view('/documention-image-slider', 'admin.site-documention.image-slider')->name('documention.image.slider');

});


Route::get('/users/logout', 'Auth\LoginController@userLogout')->name('users.logout');

Route::prefix('manage')->group( function() {
    
    Route::get('/users', 'ManageController@users')
        ->name('manage.all.users');
    Route::post('/search/users','ManageController@userSearch')
        ->name('users.search');
    Route::get('/get/online/users', 'ManageController@getOnlineUsers')
        ->name('admin.get.online.users');
    
    Route::put('/user/{id}', 'ManageController@userUpdate')
        ->name('manage.user.update');
    Route::get('/user/{id}/edit', 'ManageController@userEdit')
        ->name('manage.user.edit');
    Route::post('/user/delete', 'ManageController@userDelete')
        ->name('manage.user.delete');

    Route::get('/roles', 'ManageController@roles')
        ->name('manage.all.roles');
    Route::post('/role/create', 'ManageController@rolesStore')
        ->name('role.store');
    Route::get('/role/{id}/edit', 'ManageController@rloeEdit')
        ->name('roles.edit');
    Route::put('/roles/{id}', 'ManageController@rolesUpdate')
        ->name('roles.update');
    Route::delete('/role/destroy/{id}', 'ManageController@roleDestroy')
        ->name('role.destroy');

    // api login ips
    Route::post('/api/user-id={id}/ips', 'ManageController@userLoginIps')
        ->name('user.login.ips'); 

    Route::get('/permissions', 'ManageController@permissions')
        ->name('manage.all.permissions');
    Route::post('/permission/create', 'ManageController@permissionStore')
        ->name('permission.store');
    Route::get('/permission/{id}/edit', 'ManageController@permissionEdit')
        ->name('permissions.edit');
    Route::put('/permissions/{id}', 'ManageController@permissionUpdate')
        ->name('permissions.update');
    Route::delete('/permission/destroy/{id}', 'ManageController@permissionDestroy')
        ->name('permissions.destroy');
        
});
 

// user setting 
Route::get('user/settings', 'SettingController@index')
    ->name('user.settings');
Route::post('user/settings', 'SettingController@store')
    ->name('user.settings.store'); 
 
// restaurants 
Route::get('/', 'RestaurantController@index')
    ->name('restaurant.index'); 
Route::get('/api/menu', 'RestaurantController@apiIndexMenu');
Route::get('/api/menu-item', 'RestaurantController@apiIndexMenuItem');
Route::get('/api/open-hourses', 'RestaurantController@apiOpenHourses');
Route::get('/api/locations', 'RestaurantController@apiLocations');
Route::get('/restaurant-menu', 'RestaurantController@menu')
    ->name('restaurant.menu');
Route::get('/restaurant-menu/{id}', 'RestaurantController@menuShow')
    ->name('restaurant.menu.show');
Route::get('/restaurant-menu-item/{id}', 'RestaurantController@menuItemShow')
    ->name('restaurant.menu.item.show');
Route::get('/restaurant-gallery', 'RestaurantController@gallery')
    ->name('restaurant.gallery');
Route::get('/restaurant-gallery/show/{id}', 'RestaurantController@galleryShow')
    ->name('restaurant.gallery.show'); 
Route::get('/restaurant-team', 'RestaurantController@team')
    ->name('restaurant.team');
Route::get('/restaurant-contact', 'RestaurantController@contact')
    ->name('restaurant.contact');
Route::get('/restaurant-blog', 'RestaurantController@blog')
    ->name('restaurant.blog');
Route::get('/restaurant-blog/post-view/{id}', 'RestaurantController@blogPostView')
    ->name('restaurant.blog.post.view');
Route::get('/restaurant-blog/post-by-tag/{id}', 'RestaurantController@blogPostByTagid')
    ->name('restaurant.get.blog.post.bytag');
Route::get('/restaurant-blog/post-by-catagory/{id}', 'RestaurantController@blogPostBycatagoryid')
    ->name('restaurant.get.blog.post.bycatagory');
Route::get('/restaurant-blog/post-by-author/{id}', 'RestaurantController@blogPostByauthorid')
    ->name('restaurant.get.blog.post.byauthor');

Route::any('/tag/{id}/menu-item', 'SearchController@menuitemsBytag')
    ->name('restaurant.menu.item.tag.search');
Route::post('/restaurant-blog/search/posts', 'SearchController@postsSearch')
    ->name('restaurant.post.search');

// ApiRestaurantController
Route::post('/api/galleries', 'Api\ApiRestaurantController@galleries')
    ->name('restaurant.api.galleries');
Route::post('/api/user/galleries', 'Api\ApiRestaurantController@userGalleries')
    ->name('restaurant.api.user.galleries');
Route::post('/api/issliders', 'Api\ApiRestaurantController@isSliderImages')
    ->name('restaurant.api.issliders');
Route::post('/api/gallery-show/page', 'Api\ApiRestaurantController@galleries')
    ->name('restaurant.api.gallery.show');
Route::post('/api/user/images', 'Api\ApiRestaurantController@userImages')
    ->name('restaurant.api.userprofile.images');    
Route::get('/api/map-marker', 'Api\ApiRestaurantController@mapMarker');
Route::any('/api/post-image/upload', 'Api\ApiRestaurantController@postImageUpload')
    ->name('post.image.upload');  

Route::get('/restaurant-posts/user_id={user_id}/all', 'PostController@index')
    ->name('restaurant.member.posts');
Route::get('/restaurant-posts/create', 'PostController@create')
    ->name('restaurant.post.create')
    ->middleware('can:can_create_post');
Route::post('/restaurant-posts/store', 'PostController@store')
    ->name('restaurant.post.store')
    ->middleware('can:preview_profile');
Route::get('/restaurant-posts/{id}/edit', 'PostController@edit')
    ->name('restaurant.post.edit')
    ->middleware('can:can_edit_post');    
Route::put('/restaurant-posts/update/{id}', 'PostController@update')
    ->name('restaurant.post.update')
    ->middleware('can:can_edit_post');
Route::post('/restaurant-posts/destroy', 'PostController@destroy')
    ->name('restaurant.post.destroy')
    ->middleware('can:can_delete_post');
Route::delete('/restaurant-posts/destroy/{id}', 'PostController@destroyOne')
    ->name('restaurant.post.destroy.one')
    ->middleware('can:can_delete_post');   
Route::post('/users-posts/search', 'PostController@usersPostSearch')
    ->name('users.post.search');  

Route::post('/restaurant-posts/tag/create', 'PostController@tagCreate')
    ->name('restaurant.post.tag.create');
Route::post('/restaurant-posts/catagory/create', 'PostController@catagoryCreate')
    ->name('restaurant.post.catagory.create'); 
Route::post('/restaurant-posts/tag/delete', 'PostController@postTagDelete')
    ->name('restaurant.post.tag.delete');   
      
// comments  
Route::get('/all-comments', 'CommentController@commentsall')
    ->name('post.comment.all'); 
Route::get('/post/{post_id}/comments', 'CommentController@postComments')
    ->name('post.comment.index');
Route::get('/post={post_id}/comment/{id}', 'CommentController@show')
    ->name('post.comment.show');
Route::put('/post/comment/update/{id}', 'CommentController@update')
    ->name('post.comment.update');
Route::post('/post/comment/destroyselected', 'CommentController@destroySelected')
    ->name('comments.destroy.selected');
Route::post('/post/comment', 'CommentController@store')
    ->name('post.comment.store');
Route::delete('/post/comment/destroy/{id}', 'CommentController@destroy')
    ->name('post.comment.destroy');



 
