# googlemap-in-laravel
how to use google map in laravel - Just Instruction


*** getting saved data form database
   ---------------------------------------------

	01. "ApiRestaurantController.php" file in to "Controllers> Api" directory

	02. in routes web.php add 

		Route::get('/api/map-marker', 'Api\ApiRestaurantController@mapMarker');

 

***  google api key
   ---------------------------------------------


	03. in .env file add   

		GOOGLE_APIKEY=your google api key here

	04. "googlemap.php" file in to "config" directory


*** add div element
   ---------------------------------------------


	05. for view map with id: <div id="map"></div>
	
	06. add style


 
*** javascript part
   ---------------------------------------------


	07. "goglemap.js" file in to "public > js" directory

	08. in layout "app.blade.php" file add

		<script src="{{ asset('js/goglemap.js') }}" defer></script>
		<script src="https://maps.googleapis.com/maps/api/js?key={{config('googlemap')['map_apikey']}}&callback=initMap" async defer></script>
    
    
