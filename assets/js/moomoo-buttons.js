(function($){
    $(window).on('elementor/frontend/init', () => {
    	/** buddle effect */
    	 function moomooButtons($element){   
	       	
	       	/** treat button effect */
			if($(".treat-button").length>=1){
				elButton = document.querySelector(".treat-button");
				elWrapper = document.querySelector(".treat-wrapper");
				treatmojis = JSON.parse($('.elementor-moomoo-buttons .treat-wrapper .treatmojis').text());
				elButton.addEventListener("click", addTreats);
				$(".treat-button").click(function(event) {			
					treatmojis = JSON.parse($(this).next('.treatmojis').text());
				});
			}
			//treatmojis = JSON.parse($('.elementor-moomoo-buttons .treat-wrapper .treatmojis').text());
			//console.log(treatmojis);
			//console.log($(".treat-button").length);
	       	/** end treat button effect */

	       	var bubblyButtons = document.getElementsByClassName("bubbly-button");
	       	if(bubblyButtons.length >=1){
	       		for (var i = 0; i < bubblyButtons.length; i++) {
				  bubblyButtons[i].addEventListener('click', animateButton, false);
				}
	       	}
       		if($('.button--bubble').length>=1){
	       		buddle_effect();
			}
	           
	   };
	   /** buddle_effect */
	   	
    	function buddle_effect(){
    		$('.button--bubble').each(function() {
    			var bt1 = document.querySelectorAll('.mm-bubble-effect')[0];
  				var bt1c = document.querySelector('.button__container');
			  var $circlesTopLeft = $(this).parent().find('.circle.top-left');
			  var $circlesBottomRight = $(this).parent().find('.circle.bottom-right');

			  var tl = new TimelineLite();
			  var tl2 = new TimelineLite();

			  var btTl = new TimelineLite({ paused: true });

			  tl.to($circlesTopLeft, 1.2, { x: -25, y: -25, scaleY: 2, ease: SlowMo.ease.config(0.1, 0.7, false) });
			  tl.to($circlesTopLeft.eq(0), 0.1, { scale: 0.2, x: '+=6', y: '-=2' });
			  tl.to($circlesTopLeft.eq(1), 0.1, { scaleX: 1, scaleY: 0.8, x: '-=10', y: '-=7' }, '-=0.1');
			  tl.to($circlesTopLeft.eq(2), 0.1, { scale: 0.2, x: '-=15', y: '+=6' }, '-=0.1');
			  tl.to($circlesTopLeft.eq(0), 1, { scale: 0, x: '-=5', y: '-=15', opacity: 0 });
			  tl.to($circlesTopLeft.eq(1), 1, { scaleX: 0.4, scaleY: 0.4, x: '-=10', y: '-=10', opacity: 0 }, '-=1');
			  tl.to($circlesTopLeft.eq(2), 1, { scale: 0, x: '-=15', y: '+=5', opacity: 0 }, '-=1');

			  var tlBt1 = new TimelineLite();
			  var tlBt2 = new TimelineLite();
			 
			  
			  tlBt1.set($circlesTopLeft, { x: 0, y: 0, rotation: -45 });
			  tlBt1.add(tl);

			  tl2.set($circlesBottomRight, { x: 0, y: 0 });
			  tl2.to($circlesBottomRight, 1.1, { x: 30, y: 30, ease: SlowMo.ease.config(0.1, 0.7, false) });
			  tl2.to($circlesBottomRight.eq(0), 0.1, { scale: 0.2, x: '-=6', y: '+=3' });
			  tl2.to($circlesBottomRight.eq(1), 0.1, { scale: 0.8, x: '+=7', y: '+=3' }, '-=0.1');
			  tl2.to($circlesBottomRight.eq(2), 0.1, { scale: 0.2, x: '+=15', y: '-=6' }, '-=0.2');
			  tl2.to($circlesBottomRight.eq(0), 1, { scale: 0, x: '+=5', y: '+=15', opacity: 0 });
			  tl2.to($circlesBottomRight.eq(1), 1, { scale: 0.4, x: '+=7', y: '+=7', opacity: 0 }, '-=1');
			  tl2.to($circlesBottomRight.eq(2), 1, { scale: 0, x: '+=15', y: '-=5', opacity: 0 }, '-=1');
			  
			  tlBt2.set($circlesBottomRight, { x: 0, y: 0, rotation: 45 });
			  tlBt2.add(tl2);

			  btTl.add(tlBt1);
			  btTl.to($(this).parent().find('.mm-effect-button'), 0.8, { scaleY: 1.1 }, 0.1);
			  btTl.add(tlBt2, 0.2);
			  btTl.to($(this).parent().find('.mm-effect-button'), 1.8, { scale: 1, ease: Elastic.easeOut.config(1.2, 0.4) }, 1.2);

			  btTl.timeScale(2.6);

			  $(this).on('mouseover', function(event) {
			    btTl.restart();;
			    event.stopImmediatePropagation();
			  });
				
			 

			  
			});
    	}
    	/** end buddle_effect */
       	
	    /** @type {treat button effect} [description] */
       	let width = window.innerWidth;
		let height = window.innerHeight;
		const body = document.body;

		var elButton = document.querySelector(".treat-button");
		var elWrapper = document.querySelector(".treat-wrapper");

		function getRandomArbitrary(min, max) {
		  return Math.random() * (max - min) + min;
		}

		function getRandomInt(min, max) {
		  return Math.floor(Math.random() * (max - min + 1)) + min;
		}

		var treatmojis = ["💖","💰","🍬", "🍫", "🍭", "🍡", "🍩", "🍪", "🍒"];
		const treats = [];
		const radius = 15;

		const Cd = 0.47; // Dimensionless
		const rho = 1.22; // kg / m^3
		const A = Math.PI * radius * radius / 10000; // m^2
		const ag = 9.81; // m / s^2
		const frameRate = 1 / 60;

		function createTreat() /* create a treat */ {
		  const vx = getRandomArbitrary(-10, 10); // x velocity
		  const vy = getRandomArbitrary(-10, 1);  // y velocity
		  
		  const el = document.createElement("div");
		  el.className = "treat";

		  const inner = document.createElement("span");
		  inner.className = "inner";
		  inner.innerHTML = treatmojis[getRandomInt(0, treatmojis.length - 1)];
		  el.appendChild(inner);
		  
		  elWrapper.appendChild(el);

		  const rect = el.getBoundingClientRect();

		  const lifetime = getRandomArbitrary(2000, 3000);

		  el.style.setProperty("--lifetime", lifetime);

		  const treat = {
		    el,
		    absolutePosition: { x: rect.left, y: rect.top },
		    position: { x: rect.left, y: rect.top },
		    velocity: { x: vx, y: vy },
		    mass: 0.1, //kg
		    radius: el.offsetWidth, // 1px = 1cm
		    restitution: -.7,
		    
		    lifetime,
		    direction: vx > 0 ? 1 : -1,

		    animating: true,

		    remove() {
		      this.animating = false;
		      this.el.parentNode.removeChild(this.el);
		    },

		    animate() {
		      const treat = this;
		      let Fx =
		        -0.5 *
		        Cd *
		        A *
		        rho *
		        treat.velocity.x *
		        treat.velocity.x *
		        treat.velocity.x /
		        Math.abs(treat.velocity.x);
		      let Fy =
		        -0.5 *
		        Cd *
		        A *
		        rho *
		        treat.velocity.y *
		        treat.velocity.y *
		        treat.velocity.y /
		        Math.abs(treat.velocity.y);

		      Fx = isNaN(Fx) ? 0 : Fx;
		      Fy = isNaN(Fy) ? 0 : Fy;

		      // Calculate acceleration ( F = ma )
		      var ax = Fx / treat.mass;
		      var ay = ag + Fy / treat.mass;
		      // Integrate to get velocity
		      treat.velocity.x += ax * frameRate;
		      treat.velocity.y += ay * frameRate;

		      // Integrate to get position
		      treat.position.x += treat.velocity.x * frameRate * 250;
		      treat.position.y += treat.velocity.y * frameRate * 250;
		      
		      treat.checkBounds();
		      treat.update();
		    },
		    
		    checkBounds() {

		      if (treat.position.y > height - treat.radius) {
		        treat.velocity.y *= treat.restitution;
		        treat.position.y = height - treat.radius;
		      }
		      if (treat.position.x > width - treat.radius) {
		        treat.velocity.x *= treat.restitution;
		        treat.position.x = width - treat.radius;
		        treat.direction = -1;
		      }
		      if (treat.position.x < treat.radius) {
		        treat.velocity.x *= treat.restitution;
		        treat.position.x = treat.radius;
		        treat.direction = 1;
		      }

		    },

		    update() {
		      const relX = this.position.x - this.absolutePosition.x;
		      const relY = this.position.y - this.absolutePosition.y;

		      this.el.style.setProperty("--x", relX);
		      this.el.style.setProperty("--y", relY);
		      this.el.style.setProperty("--direction", this.direction);
		    }
		  };

		  setTimeout(() => {
		    treat.remove();
		  }, lifetime);

		  return treat;
		}


		function animationLoop() {
		  var i = treats.length;
		  while (i--) {
		    treats[i].animate();

		    if (!treats[i].animating) {
		      treats.splice(i, 1);
		    }
		  }

		  requestAnimationFrame(animationLoop);
		}

		animationLoop();

		function addTreats(e) {
		  e.preventDefault();
		  //cancelAnimationFrame(frame);
		  if (treats.length > 40) {
		    return;
		  }
		  for (let i = 0; i < 10; i++) {
		    treats.push(createTreat());
		  }
		}

		//elButton.addEventListener("click", addTreats);
		//elButton.click();

		window.addEventListener("resize", () => {
		  width = window.innerWidth;
		  height = window.innerHeight;
		});
      
       var animateButton = function(e) {
		  e.preventDefault();
		  //reset animation
		  e.target.classList.remove('animate');
		  
		  e.target.classList.add('animate');
		  setTimeout(function(){
		    e.target.classList.remove('animate');
		  },700);
		};

      

       // moomoo-team-memeber-map-light-hight get from get_name
        elementorFrontend.hooks.addAction('frontend/element_ready/moomoo-buttons.default', moomooButtons);
    });
})(jQuery)

