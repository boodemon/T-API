(function($){
var pageTitle	= document.title; //HTML page title
    var pageUrl		= location.href; //Location of this page
	
	$('.share-btn-wrp li').click(function(event){
		var shareName = $(this).attr('class').split(' ')[0]; //get the first class name of clicked element
		switch(shareName) //switch to different links based on different social name
		{
			case 'facebook':
				OpenShareUrl('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(pageUrl) + '&amp;title=' + encodeURIComponent(pageTitle));
				break;
			case 'twitter':
				OpenShareUrl('http://twitter.com/home?status=' + encodeURIComponent(pageTitle + ' ' + pageUrl));
				break;
			case 'pinterest':
				 var pinOneButton = document.querySelector('.pinterest');
				 pinOneButton.addEventListener('click', function(e) {
					PinUtils.pinOne({
						media: e.target.getAttribute('data-media'),
						description: e.target.getAttribute('data-description')
					});
				});
				//OpenShareUrl('http://twitter.com/home?status=' + encodeURIComponent(pageTitle + ' ' + pageUrl));
				break;
/*				
			case 'line':
				$('iframe.line-it-button').find('#button').trigger('click');
				//$('.line-it-button').trigger('click');
				break;
*/				
			case 'digg':
				OpenShareUrl('http://www.digg.com/submit?phase=2&amp;url=' + encodeURIComponent(pageUrl) + '&amp;title=' + encodeURIComponent(pageTitle));
				break;
			case 'stumbleupon':
				OpenShareUrl('http://www.stumbleupon.com/submit?url=' + encodeURIComponent(pageUrl) + '&amp;title=' + encodeURIComponent(pageTitle));
				break;
			case 'delicious':
				OpenShareUrl('http://del.icio.us/post?url=' + encodeURIComponent(pageUrl) + '&amp;title=' + encodeURIComponent(pageTitle));
				break;
			case 'gplus':
				OpenShareUrl('https://plus.google.com/share?url=' + encodeURIComponent(pageUrl) + '&amp;title=' + encodeURIComponent(pageTitle));
				break;
			case 'email':
				OpenShareUrl('mailto:?subject=' + pageTitle + '&body=Found this useful link for you : ' + pageUrl);
				break;
			case 'print' : 
				window.print();
				break;
		}
		
	});

	function OpenShareUrl(openLink){
		//Parameters for the Popup window
        winWidth    = 650; 
        winHeight   = 450;
        winLeft     = ($(window).width()  - winWidth)  / 2,
        winTop      = ($(window).height() - winHeight) / 2,
        winOptions   = 'width='  + winWidth  + ',height=' + winHeight + ',top='    + winTop    + ',left='   + winLeft;
        window.open(openLink,'Share This Link',winOptions); //open Popup window to share website.
        return false;
	}
}(jQuery));