jQuery(document).ready(function($){
	
	//-----------------------------------------------------------------
	// MHLoveit
	//-----------------------------------------------------------------
    var $mh_share = $('.mh_share'),
        $mh_share_ul = $('.mh_share ul');
    
	$('body').on('click','.mh-loveit', function() {

			var $loveitLink = $(this);
			var $id = $(this).attr('id');
			var $that = $(this);
			
			if($loveitLink.hasClass('loved')) return false;
			if($(this).hasClass('inactive')) return false;
			
			var $dataToPass = {
				action: 'mh-loveit', 
				loves_id: $id,
                loveit_nonce: mhLoveit.loveitNonce
			}
			
			$.post(mhLoveit.ajaxurl, $dataToPass, function(data){
				$loveitLink.find('span').html(data);
				$loveitLink.addClass('loved').attr('title','أنت معجب بهذا!');
				$loveitLink.find('span').css({'opacity': 1,'width':'auto'});
			});
			
			$(this).addClass('inactive');
			
			return false;
	});
    
    //share pop-up
    if ($mh_share.length) {
        $( 'body' ).on( 'click', '.post_share_item_url', function() {
			var $this_el = $(this),
				share_link = $this_el.prop( 'href' ),
                left	= ( $( window ).width()/2 ) - ( 550/2 ),
                top		= ( $( window ).height()/2 ) - ( 450/2 ),
                popup_window = window.open( share_link, '', 'scrollbars=1, height=450, width=550, left=' + left + ', top=' + top );

			if ( window.focus ) {
				popup_window.focus();
			}

			return false;
		}); //end share popup

        
        //hover 
        if ($mh_share_ul.hasClass('mh_share_type_hover')) {
            $mh_share_ul.hover(function () {
               $(this).addClass('hover');
                }, function () {
                $(this).removeClass('hover');
           });
        }
    }
    function getRightClick(e) {
        var rightclick;
        if (!e) var e = window.event;
        if (e.which) rightclick = (e.which == 3);
        else if (e.button) rightclick = (e.button == 2);
            return rightclick;
    }

    function getSelectionText() {
        var text = "";
        if (window.getSelection) {
            text = window.getSelection().toString();
        } else if (document.selection && document.selection.type != "Control") {
            text = document.selection.createRange().text;
        }
        return text;
    }
    if( $('body').hasClass('mh_selecttweet') ){
        // select & tweet
        $('.entry-content').mousedown(function (event) {
            $('body').attr('mouse-top',event.clientY+window.pageYOffset);
            $('body').attr('mouse-left',event.clientX);

            if(!getRightClick(event) && getSelectionText().length > 0) {
                $('.mh-select-tweet').remove();
                document.getSelection().removeAllRanges();
            }
        });

        $('.entry-content').mouseup(function (event) {
            var t = $(event.target);
            var st = getSelectionText();

            if(st.length > 5 && !getRightClick(event)) {
                mts = $('body').attr('mouse-top');
                mte = event.clientY+window.pageYOffset;
                if(parseInt(mts) < parseInt(mte)) mt = mts;
                    else mt = mte;

                mlp = $('body').attr('mouse-left');
                mrp = event.clientX;
                ml = parseInt(mlp)+(parseInt(mrp)-parseInt(mlp))/2;

                sl = window.location.href.split('?')[0];

                maxl = 114;
                st = st.substring(0,maxl);

                // append the sharing button
                $('body').append("<a href=\"https://twitter.com/share?url="+encodeURIComponent(sl)+"&text="+encodeURIComponent(st)+"\" class='mh-select-tweet mh-select-tweet-icon mh-icon-before' onclick=\"window.open(this.href, \'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600\');return false;\"></a>");

                $('.mh-select-tweet').css({
                    position: 'absolute',
                    top: parseInt(mt)-55,
                    left: parseInt(ml)
                });
            }
        });
    }
});