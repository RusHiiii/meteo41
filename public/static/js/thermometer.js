/*
 * HTML5 Canvas Gauge implementation
 * 
 * This code is subject to MIT license.
 *
 * Copyright (c) 2012 Mykhailo Stadnyk <mikhus@gmail.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the
 * Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 * 
 * @authors: Mykhailo Stadnyk <mikhus@gmail.com>
 *           Chris Poile <poile@edwards.usask.ca>
 *
 * @authors: Raúl Martínez
 *
 * @authors: Jordi Nonell ( Barelly 3 lines )
 *
 */
var Thermometer = function( container, config) {

	/**
	 *	Div container
	 */
	this.container = container;
	
	/**
	 *  Default gauge configuration
	 */
	this.config = {
		width       : 200,
		height      : 200,
		dirGauge	: false,
		title       : false, 
		maxValue    : 60,
		minValue    : -40,
		majorTicks  : ['-40', '-20', '0', '20', '40', '60'],
		minorTicks  : 0,
		strokeTicks : true,
		units       : "ºC", //false
		valueFormat : { int : 1, dec : 1 },
		glow        : false,
		animation   : {
			delay    : 10,
			duration : 250,
			fn       : 'cycle'
		},
		colors : {
			plate      : '#fff',
			majorTicks : '#fff',
			minorTicks : '#666',
			title      : '#fff',
			units      : '#888',
			numbers    : '#888',
			needle     : { start : '#08b', end : '#08b' }
		},
		highlights  : [{
			from  : -40,
			to    : -20,
			color : '#eee'
		}, {
			from  : -20,
			to    : 0,
			color : '#ddd'
		}, {
			from  : 0,
			to    : 20,
			color : '#ccc'
		}, {
			from  : 20,
			to    : 40,
			color : '#bbb'
		}, {
			from  : 40,
			to    : 60,
			color : '#aaa'
		}]
	};

	var
		value     = 0,
		self      = this,
		fromValue = 0,
		toValue   = 0,
		imready   = true
	;

	/**
	 * Sets a new value to gauge and updates the gauge view
	 * 
	 * @param {Number} val  - the new value to set to the gauge
	 * @return {Gauge} this - returns self
	 */
	this.setValue = function( val) {

		//fromValue = config.animation ? value : val;
		fromValue = val;
		
		var dv = (config.maxValue - config.minValue) / 100;

		toValue = val > config.maxValue ?
			toValue = config.maxValue + dv :
				val < config.minValue ?
					config.minValue - dv : 
						val
		;
		
		value = val;
		
		this.draw();

		return this;
	};
	
	/**
	 * Ready event for the gauge. Use it whenever you
	 * initialize the gauge to be assured it was fully drawn
	 * before you start the update on it
	 * 
	 * @event {Function} onready
	 */
	this.onready = function() {};
	
	function applyRecursive( dst, src) {
		for (var i in src) {
			// modification by Chris Poile, Oct 08, 2012. More correct check of an Array instance
			if (typeof src[i] == "object" && !(Object.prototype.toString.call( src[i]) === '[object Array]')) {
				if (typeof dst[i] != "object") {
					dst[i] = {};
				}

				applyRecursive( dst[i], src[i]);
			} else {
				dst[i] = src[i];
			}
		}
	};

	applyRecursive( this.config, config);
	config = this.config;
	fromValue = value = config.minValue;
	
	if (!this.container) {
		throw Error( "Canvas element was not specified when creating the Gauge object!");
	}

	var
		canvas = this.container.tagName ? this.container : document.getElementById( this.container),
		ctx = canvas.getContext( '2d'),
		cache, CW, CH, CX, CY, max
	;
	function baseInit() {
		canvas.width  = config.width;
		canvas.height = config.height;

		cache = canvas.cloneNode( true);
		cctx = cache.getContext( '2d');
		CW  = canvas.width;
		CH  = canvas.height;
		CX  = CW / 2;
		CY  = CH / 2;
		max = CX < CY ? CX : CY;
		
		cache.i8d = false;

		// translate cache to have 0, 0 in center
		cctx.translate( CX, CY);
		cctx.save();

		// translate canvas to have 0,0 in center
		ctx.translate( CX, CY);
		ctx.save();
	};

	// do basic initialization
	baseInit();

	/**
	 * Updates the gauge config
	 *
	 * @param  {Object} config
	 * @return {Gauge}
	 */
	this.updateConfig = function( config) {
        applyRecursive( this.config, config);
        baseInit();
        this.draw();
        return this;
    };
	
	// defaults
	ctx.lineCap = "round";

	/**
	 * Draws the gauge. Normally this function should be used to
	 * initially draw the gauge
	 * 
	 * @return {Gauge} this - returns the self Gauge object
	 */
	this.draw = function() {
		if (!cache.i8d) {
			// clear the cache
			cctx.clearRect( -CX, -CY, CW, CH);
			cctx.save();

			var tmp = ctx;
			ctx = cctx;		

			drawHighlights();
			drawMajorTicks();
			drawNumbers();
			
			cache.i8d = true;
			ctx = tmp;
			delete tmp;
		}
		
		// clear the canvas
		ctx.clearRect( -CX, -CY, CW, CH);
		ctx.save();

		ctx.drawImage( cache, -CX, -CY, CW, CH);
		
		if( value != null ){
			drawWater();
			drawLevel();
			drawValueBox();
		}
		drawGlass();
		
		return this;
	};
	
	// draws the highlight colors
	function drawHighlights() {
		ctx.save();

		var 
			x0 = -max / 100 * 30,
			y0 = -max / 100 * 70,
			
			o2= -max / 100 * 93-y0,
			ticksRun = 2 * y0
		;

		//Draw ticks
		for(var i=0, s = config.highlights.length; i < s; ++i){
			var	hlt = config.highlights[i],
				vd = (config.maxValue - config.minValue) / ticksRun,
				sa =  (hlt.from - config.minValue)/ vd,
				ea =  (hlt.to - config.minValue)/ vd
			
			ctx.translate(x0, -y0 + o2);
			
			ctx.beginPath();
			ctx.moveTo(0,sa);
			ctx.lineTo(14,sa);
			ctx.lineTo(14,ea);
			ctx.lineTo(0, ea);
			
			ctx.closePath();
			ctx.fillStyle = hlt.color;
			ctx.fill();
		
			ctx.restore();
			ctx.save();
		}
	};
	
	function drawMajorTicks(){
		
		var 
			x0 = -max / 100 * 30,
			y0 = -max / 100 * 70,
			
			o2= -max / 100 * 93-y0,
			ticksRun = 2 * y0
		;
		
		ctx.lineWidth = 2;
		ctx.strokeStyle = config.colors.majorTicks;
		ctx.save();
		
		//Draw vertical line
		ctx.translate(0,o2);
		
		ctx.beginPath();
		ctx.moveTo(x0+14,y0); 
		ctx.lineTo(x0+14,-y0);
		ctx.stroke();
		
		ctx.restore();
		ctx.save();
		
		//Draw ticks
		for(var i=0; i<config.majorTicks.length; ++i){
			var a = i * (ticksRun / (config.majorTicks.length-1));

			ctx.translate(0,-a + o2);
			
			ctx.beginPath();
			ctx.moveTo(x0, y0);
			ctx.lineTo(x0+14, y0);
			ctx.stroke();
		
			ctx.restore();
			ctx.save();
		}
	}
	
	function drawNumbers(){
		var 
			x0 = -max / 100 * 40,
			y0 = -max / 100 * 70,
			o2= -max / 100 * 93-y0,
			ticksRun = 2 * y0
		;
		
		for(var i=0; i<config.majorTicks.length; ++i){
			var a = i * (ticksRun / (config.majorTicks.length-1));

			ctx.font      =  22 * (max / 200) + "px Arial";
			ctx.fillStyle = '#fff';
			ctx.lineWidth = 0;
			ctx.textAlign = "right";
			ctx.fillText( config.majorTicks[i], x0, -y0 + a + o2 + 3);
		}
	}
	function drawGlass(){
		
		var 
			x0 = -max / 100 * 20,
			y0 = -max / 100 * 93,
			y1 = -max / 100 * 70,
			d1 = -2 * x0,
			d2 = -2 * y0,
			r0 =20,
			r1 =d1/Math.sqrt(2),
			o1 = x0 + max / 100 * 55,
			o2 = -max / 100 * 98 - y0;
		;
		
		ctx.lineWidth = 2;
		ctx.strokeStyle='#fff';
		ctx.save();
		
		ctx.translate(o1,0);
		
		ctx.beginPath();
		ctx.moveTo(x0 + d1, y0 + r0);
		ctx.arc(0,-y1,r1,radians(-45),radians(-135));
		ctx.lineTo(x0 , y0 + r0 + o2);
		ctx.quadraticCurveTo(x0, y0 + o2, x0 + r0, y0 + o2 );		
		ctx.lineTo(x0 + d1 -r0, y0 + o2);
		ctx.quadraticCurveTo(x0 + d1, y0 + o2, x0 + d1, y0 + r0 + o2 );
		ctx.closePath();

		ctx.stroke();
		
		ctx.restore();
		ctx.save();
	}
	
	function drawWater(){
		var 
			x0 = -max / 100 * 15,
			y0 = -max / 100 * 93,
			y1 = -max / 100 * 70,
			d1 = -2 * x0,
			d2 = -2 * y0,
			r0 =20,
			r1 =(d1/Math.sqrt(2))*(16.5/15),
			o1 = x0 + max / 100 * 50,
			o2 = -max / 100 * 98 - y0,
			a1 = -Math.PI/2 + Math.asin(-x0/r1),
			a2 = -Math.PI/2 - Math.asin(-x0/r1)
		;
		
		ctx.lineWidth = 2;
		ctx.fillStyle='#0d9dd7';
		ctx.save();
		
		ctx.translate(o1,0);
		
		ctx.beginPath();
		ctx.moveTo(x0 + d1, y0 + r0);
		ctx.arc(0,-y1,r1, a1,  a2);
		ctx.lineTo(x0 , y0 + r0);
		ctx.quadraticCurveTo(x0, y0 + o2, x0 + r0, y0 );		
		ctx.lineTo(x0 + d1 -r0, y0);
		ctx.quadraticCurveTo(x0 + d1, y0 + o2, x0 + d1, y0 + r0 );
		ctx.closePath();

		ctx.fill();
		
		ctx.restore();
		ctx.save();
	}
	
	function drawLevel(){
		var 
			x0 = -max / 100 * 20,
			y0 = -max / 100 * 70,
			d1 = -2 * x0,
			d2 = -2 * y0,
			o1 = x0 + max / 100 * 55,
			o2= -max / 100 * 93 - y0
		;
		
		if (fromValue < 0) {
			fromValue = Math.abs(config.minValue - fromValue);
		} else if (config.minValue > 0) {
			fromValue -= config.minValue
		} else {
			fromValue = Math.abs(config.minValue) + fromValue;
		}

		v1=((fromValue/(config.maxValue - config.minValue)*100))*100/70;
		
		ctx.fillStyle='#1e202b';
		ctx.save();
		
		ctx.translate(o1,o2);
		
		ctx.beginPath();
		ctx.moveTo(x0 + d1, y0 + o2);
		ctx.lineTo(x0 + d1, y0 + d2 - v1);
		ctx.lineTo(x0, y0 + d2 - v1);
		ctx.lineTo(x0, y0 + o2);
		ctx.closePath();

		ctx.fill();
		
		ctx.restore();
		ctx.save();
	
	}
	
	function drawValueBox( ){
		
		ctx.save();
		ctx.font = 50 * (max / 200) + "px Arial";

		var
			text = padValue( value),
			x0 = -max / 100 * 46,
			y0 = max / 100 * 86
			unit=null;
		;
		if (config.units) {
			unit=config.units;
		}
		
		ctx.save();
		ctx.restore();

		ctx.fillStyle = "#fff";
		ctx.textAlign = "center";
		ctx.fillText( text+unit, x0, y0);

		ctx.restore();
	}
	
	function padValue( val) {
		var
			cdec = config.valueFormat.dec,
			cint = config.valueFormat.int
		;
		val = parseFloat( val);

		var n = (val < 0);

		val = Math.abs( val);

		if (cdec > 0) {
			val = val.toFixed( cdec).toString().split( '.');
	
			for (var i = 0, s = cint - val[0].length; i < s; ++i) {
				val[0] = '0' + val[0];
			}

			val = (n ? '-' : '') + val[0] + '.' + val[1];
		} else {
			val = Math.round( val).toString();

			for (var i = 0, s = cint - val.length; i < s; ++i) {
				val = '0' + val;
			}

			val = (n ? '-' : '') + val
		}

		return val;
	};
	/**
	 * Transforms degrees to radians
	 */
	function radians( degrees) {
		return degrees * Math.PI / 180;
	};
};
var DThermometer = function (container, value, options) 
{
	var gauge = new Thermometer(container, options); 
	gauge.draw();

		//setInterval( function() { 
			gauge.setValue(value);
		//}, 1000);
}