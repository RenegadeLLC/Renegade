/*
	almMasonry

	Function to trigger built-in Ajax Load More Masonry

   @param container     object
   @param items         object
   @param selector      string
   @param animation     string
   @param speed         int
   @param masonry_init  boolean
   @param init          boolean
   @param filtering     boolean   
   @since 3.1
   @updated 3.3.2
*/


let almMasonry = (container, items, selector, animation, horizontalOrder, speed, masonry_init, init, filtering) => {	
      
   let duration = (speed+100)/1000 +'s'; // Add 100 for some delay
   let hidden = 'scale(0.5)';
   let visible = 'scale(1)';
   
   if(animation === 'zoom-out'){
      hidden = 'translateY(-20px) scale(1.25)'; 
      visible = 'translateY(0) scale(1)';
   }
   
   if(animation === 'slide-up'){
      hidden = 'translateY(50px)';
      visible = 'translateY(0)';
   } 
   
   if(animation === 'slide-down'){
      hidden = 'translateY(-50px)';
      visible = 'translateY(0)';
   } 
    
   if(animation === 'none'){
      hidden = 'translateY(0)'; 
      visible = 'translateY(0)';
   }
   
   horizontalOrder = (horizontalOrder === 'true') ? true : false;
   
	if(!filtering){
   	
		// First Run
		if(masonry_init && init){
			container.imagesLoaded( () => {				
				container.masonry({
					itemSelector: selector,
					transitionDuration: duration,
					columnWidth: selector,
					horizontalOrder: horizontalOrder,
               hiddenStyle: {
                  transform: hidden,
                  opacity: 0
               },
               visibleStyle: {
                  transform: visible,
                  opacity: 1
               }
				});
				almMasonryFadeIn(container[0].parentNode, speed); 
			});
		}
		
		// Standard
		else{
			//container.append( items ); // Append new items
			items.imagesLoaded( () => {
				//items.show();
				container.append(items).masonry( 'appended', items );
			});
		}

	} else{
		// Filtering Reset
		container.masonry('destroy'); // destroy masonry
		container.append( items );
		almMasonry(container, items, selector, animation, horizontalOrder, speed, true, true, false);
	}

};


// Fade in masonry on initial page load
let almMasonryFadeIn = (element, speed) => {
	speed = speed/10;
	let op = parseInt(element.style.opacity);  // initial opacity
	let timer = setInterval(function () { 
		if (op > 0.9){
			element.style.opacity = 1;
			clearInterval(timer);
		}
		element.style.opacity = op;
		op += 0.1;
	}, speed);
}
