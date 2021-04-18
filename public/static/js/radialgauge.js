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
 */
var RadialGauge = function( container, config) {

	/**
	 *	Div container
	 */
	this.container = container;
	
	/**
	 *  Default gauge configuration
	 */
	this.config = {
		altValue  	: false,
		width       : 200,
		height      : 200,
		dirGauge	: false,
		title       : false,
		maxValue    : 100,
		minValue    : 0,
		cardinals  	: ['N','NNE','NE','ENE','E','ESE','SE','SSE','S','SSW','SW','WSW','W','WNW','NW','NNW'],
		majorTicks  : ['0', '20', '40', '60', '80', '100'],
		minorTicks  : 0,
		majorTicksLine  : 2.5,
		strokeTicks : true,
		units       : false,
		valueFormat : { int : 1, dec : 1 },
		glow        : false,
		animation   : {
			delay    : 10,
			duration : 500,
			fn       : 'linear'
		},
		colors : {
			plate      : '#fff',
			majorTicks : '#888',
			minorTicks : '#666',
			title      : '#888',
			units      : '#888',
			numbers    : '#888',
			needle     : { start : '#08b', end : '#08b' }
		},
		highlights  : [{
			from  : 20,
			to    : 60,
			color : '#eee'
		}, {
			from  : 60,
			to    : 80,
			color : '#ccc'
		}, {
			from  : 80,
			to    : 100,
			color : '#999'
		}]
	};

	var
		value     = 0,
		self      = this,
		fromValue = 0,
		toValue   = 0,
		imready   = false,
		
		// Variables to draw a standard gauge or a [wind, flow...] direction gauge
		ticksStart = 0,
		ticksEnd = 0,
		ticksRun = 0,
		ticksCountSub = 0
	;

	/**
	 * Sets a new value to gauge and updates the gauge view
	 * 
	 * @param {Number} val  - the new value to set to the gauge
	 * @return {Gauge} this - returns self
	 */
	this.setValue = function( val) {
		fromValue = config.animation ? value : val;

		var dv = (config.maxValue - config.minValue) / 100;

		toValue = val > config.maxValue ?
			toValue = config.maxValue + dv :
				val < config.minValue ?
					config.minValue - dv : 
						val
		;

		value = val;

		config.animation ? animate() : this.draw();

		return this;
	};

	/**
	 * Clears the value of the gauge
	 * @return {Gauge}
	 */
	this.clear = function() {
		value = fromValue = toValue = this.config.minValue;
		this.draw();
		return this;
	};

	/**
	 * Returns the current value been set to the gauge
	 * 
	 * @return {Number} value - current gauge's value
	 */
	this.getValue = function() {
		return value;
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
		
		// Set the variables to draw a standard gauge or a [wind, flow...] direction gauge
		ticksStart = config.dirGauge ? 180 : 45;
		ticksEnd = config.dirGauge ? 540 : 315;
		ticksRun = ticksEnd - ticksStart;
		ticksCountSub = config.dirGauge ? 0 : 1;
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

	var animateFx = {
		linear : function( p) { return p; },
		quad   : function( p) { return Math.pow( p, 2); },
		quint  : function( p) { return Math.pow( p, 5); },
		cycle  : function( p) { return 1 - Math.sin( Math.acos( p)); },
		bounce : function( p) {
			return 1 - (function( p) {
				for(var a = 0, b = 1; 1; a += b, b /= 2) {
					if (p >= (7 - 4 * a) / 11) {
						return -Math.pow((11 - 6 * a - 11 * p) / 4, 2) + Math.pow(b, 2);
					}
				}
			})( 1 - p);
		},
		elastic : function( p) {
			return 1 - (function( p) {
				var x = 1.5;
				return Math.pow( 2, 10 * (p - 1)) * Math.cos( 20 * Math.PI * x / 3 * p);
			})( 1 - p);
		}
	};

	var animateInterval = null;

	function _animate( opts) {
		var start = new Date; 

		animateInterval = setInterval( function() {
			var
				timePassed = new Date - start,
				progress = timePassed / opts.duration
			;

			if (progress > 1) {
				progress = 1;
			}

			var animateFn = typeof opts.delta == "function" ?
				opts.delta :
				animateFx[opts.delta]
			;

			var delta = animateFn( progress);
			opts.step( delta);

			if (progress == 1) {
				clearInterval( animateInterval);
			}
		}, opts.delay || 10);
	};

	function animate() {
		animateInterval && clearInterval( animateInterval); // stop previous animation
		var
			path = (toValue - fromValue),
			from = fromValue,
			cfg  = config.animation
		;

		_animate({
			delay    : cfg.delay,
			duration : cfg.duration,
			delta    : cfg.fn,
			step     : function( delta) { fromValue = from + path * delta; self.draw(); }
		});
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

			drawPlate();
			drawHighlights();
			drawMinorTicks();
			drawMajorTicks();
			drawNumbers();
			drawTitle();

			cache.i8d = true;
			ctx = tmp;
			delete tmp;
		}

		// clear the canvas
		ctx.clearRect( -CX, -CY, CW, CH);
		ctx.save();

		ctx.drawImage( cache, -CX, -CY, CW, CH);

		if (!RadialGauge.initialized) {
			var iv = setInterval(function() {
				if (!RadialGauge.initialized) {
					return;
				}
				clearInterval( iv);
				if (value != null){
					drawUnits();
					drawValueBox();
					
					if (config.dirGauge) {
						drawPointer();
					} else {
						drawNeedle();
					}
				}
				if (!imready) {
					self.onready && self.onready();
					imready = true;
				}
			}, 10);
		} else {
			if (value != null){
				drawUnits();
				drawValueBox();
				if (config.dirGauge) {
					drawPointer();
				} else {
					drawNeedle();
				}
			}
			if (!imready) {
				self.onready && self.onready();
				imready = true;
			}
		}

		return this;
	};

	/**
	 * Transforms degrees to radians
	 */
	function radians( degrees) {
		return degrees * Math.PI / 180;
	};

	/**
	 * Linear gradient
	 */
	function lgrad( clrFrom, clrTo, len) {
		var grad = ctx.createLinearGradient( 0, 0, 0, len);  
		grad.addColorStop( 0, clrFrom);  
		grad.addColorStop( 1, clrTo);

		return grad;
	};

	function drawPlate() {
		var
			r0 = max / 100 * 93,
			d0 = max -r0,
			r1 = max / 100 * 91,
			d1 = max - r1,
			r2 = max / 100 * 88,
			d2 = max - r2,
			r3 = max / 100 * 85
		;

		ctx.save();

		if (config.glow) {
			ctx.shadowBlur  = d0;
			ctx.shadowColor = 'rgba(0, 0, 0, 0.5)';
		}

		ctx.beginPath();
		ctx.arc( 0, 0, r0, 0, Math.PI * 2, true);
		ctx.lineWidth = 2;
		ctx.strokeStyle='#fff';
		ctx.stroke();

		ctx.restore();
		ctx.save();
	};

	// major ticks draw
	function drawMajorTicks() {
		var r = max / 100 * 86;

		ctx.lineWidth = config.majorTicksLine;
		ctx.strokeStyle = config.colors.majorTicks;
		ctx.save();

		for (var i = 0; i < config.majorTicks.length; ++i) {
			var a = ticksStart + i * (ticksRun / (config.majorTicks.length - ticksCountSub));
			ctx.rotate( radians( a));

			ctx.beginPath();
			ctx.moveTo( 0, r);
			ctx.lineTo( 0, r - max / 100 * 15);
			ctx.stroke();

			ctx.restore();
			ctx.save();
		}

		if (config.strokeTicks) {
			ctx.rotate( radians( 90));

			ctx.beginPath();
			ctx.arc( 0, 0, r, radians( ticksStart), radians( ticksEnd), false);
			ctx.stroke();
			ctx.restore();
	
			ctx.save();
		}
	};

	// minor ticks draw
	function drawMinorTicks() {
		var r = max / 100 * 86;

		ctx.lineWidth = 1;
		ctx.strokeStyle = config.colors.minorTicks;

		ctx.save();

		var len = config.minorTicks * (config.majorTicks.length - ticksCountSub);

		for (var i = 0; i < len; ++i) {
			var a = ticksStart + i * (ticksRun / len);
			ctx.rotate( radians( a));

			ctx.beginPath();
			ctx.moveTo( 0, r);
			ctx.lineTo( 0, r - max / 100 * 7.5);
			ctx.stroke();

			ctx.restore();
			ctx.save();
		}
	};

	// tick numbers draw
	function drawNumbers() {
		var r = max / 100 * 55,
			increment = 0,
			adjust = 3;

		for (var i = 0; i < config.majorTicks.length; ++i) {
			var 
				a = ticksStart + i * (ticksRun / (config.majorTicks.length - ticksCountSub)),
				p = rpoint( r, radians( a))
			;
		
			if (config.dirGauge){
				increment = 12*((i+1)%2);
				adjust = 2*((i+1)%2) + 4;
			}
			ctx.font      =  (22 + increment) * (max / 200) + "px Arial";
			ctx.fillStyle = '#fff';
			ctx.lineWidth = 0;
			ctx.textAlign = "center";
			ctx.fillText( config.majorTicks[i], p.x, p.y + adjust);
		}
	};

	// title draw
	function drawTitle() {
		if (!config.title) {
			return;
		}

		ctx.save();
		ctx.font = 24 * (max / 200) + "px Arial";
		ctx.fillStyle = config.colors.title;
		ctx.textAlign = "center";
		ctx.fillText( config.title, 0, -max / 4.25);
		ctx.restore();
	};

	// units draw
	function drawUnits() {
		if (!config.units) {
			return;
		}

		ctx.save();
		ctx.font = 24 * (max / 200) + "px Arial";
		ctx.fillStyle = '#fff';
		ctx.textAlign = "center";
		ctx.fillText( config.units, 0, max / 2.6);
		ctx.restore();
	};

	function padValue( val) {
		var
			cdec = config.valueFormat.dec,
			cint = config.valueFormat.int
		;
		if (config.dirGauge){
			cdec = 0,
			cint = 1
		}
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

	function rpoint( r, a) {
		var 
			x = 0, y = r,

			sin = Math.sin( a),
			cos = Math.cos( a),

			X = x * cos - y * sin,
			Y = x * sin + y * cos
		;

		return { x : X, y : Y };
	};

	// draws the highlight colors
	function drawHighlights() {
		ctx.save();

		var r1 = max / 100 * 86;
		var r2 = r1 - max / 100 * 15;

		for (var i = 0, s = config.highlights.length; i < s; i++) {
			var
				hlt = config.highlights[i],
				vd = (config.maxValue - config.minValue) / ticksRun,
				sa = radians( ticksStart + (hlt.from - config.minValue) / vd),
				ea = radians( ticksStart + (hlt.to - config.minValue) / vd)
			;
			
			ctx.beginPath();
	
			ctx.rotate( radians( 90));
			ctx.arc( 0, 0, r1, sa, ea, false);
			ctx.restore();
			ctx.save();
	
			var
				ps = rpoint( r2, sa),
				pe = rpoint( r1, sa)
			;
			ctx.moveTo( ps.x, ps.y);
			ctx.lineTo( pe.x, pe.y);
	
			var
				ps1 = rpoint( r1, ea),
				pe1 = rpoint( r2, ea)
			;
	
			ctx.lineTo( ps1.x, ps1.y);
			ctx.lineTo( pe1.x, pe1.y);
			ctx.lineTo( ps.x, ps.y);
	
			ctx.closePath();
	
			ctx.fillStyle = hlt.color;
			ctx.fill();
	
			ctx.beginPath();
			ctx.rotate( radians( 90));
			ctx.arc( 0, 0, r2, sa - 0.2, ea + 0.2, false);
			ctx.restore();
	
			ctx.closePath();
	
			ctx.fillStyle = '#1e202b';
			ctx.fill();
			ctx.save();
		}
	};

	// draws the gauge needle
	function drawNeedle() {
		var
			r1 = max / 100 * 12,
			r2 = max / 100 * 8,

			rIn  = max / 100 * 77,
			rOut = max / 100 * 20,
			pad1 = max / 100 * 6,
			pad2 = max / 100 * 4
		;

		ctx.save();
		
		if (fromValue < 0) {
			fromValue = Math.abs(config.minValue - fromValue);
		} else if (config.minValue > 0) {
			fromValue -= config.minValue
		} else {
			fromValue = Math.abs(config.minValue) + fromValue;
		}

		ctx.rotate( radians( ticksStart + fromValue / ((config.maxValue - config.minValue) / ticksRun)));

		ctx.beginPath();
		ctx.moveTo( -pad2, -rOut);
		ctx.lineTo( -pad1, 0);
		ctx.lineTo( 0, rIn);
		ctx.lineTo( pad1, 0);
		ctx.lineTo( pad2, -rOut);
		ctx.closePath();

		ctx.fillStyle = lgrad(
			config.colors.needle.start,
			config.colors.needle.end,
			rIn - rOut
		);
		ctx.fill();

		ctx.restore();


		ctx.beginPath();
		ctx.arc( 0, 0, r1, 0, Math.PI * 2, true);
		ctx.lineWidth = 3;
		ctx.fillStyle="white"
		ctx.fill();
		
		ctx.strokeStyle='#fff';
		ctx.stroke();
		

		ctx.restore();

	};
	
	// draws the [wind, flow...] direction gauge pointer
	function drawPointer() {
		var
			r0  = max / 100 * 100,
			r1 = max / 100 * 48,
			
			rIn  = max / 100 * 64,
			rOut = max / 100 * 96,
			
			pad = max / 100 * 14
		;

		ctx.save();
		
		if (fromValue < 0) {
			fromValue = Math.abs(config.minValue - fromValue);
		} else if (config.minValue > 0) {
			fromValue -= config.minValue
		} else {
			fromValue = Math.abs(config.minValue) + fromValue;
		}

		ctx.rotate( radians( ticksStart + fromValue / ((config.maxValue - config.minValue) / ticksRun)));
		
		ctx.beginPath();
		ctx.moveTo( -pad,rOut);
		ctx.lineTo( 0, rIn);
		ctx.lineTo( pad, rOut);
		ctx.arcTo( 0, r0, -pad, rOut, r1);
		ctx.closePath();
		
		ctx.fillStyle = lgrad(
			'#0d9dd7',
			'#0d9dd7',
			rIn - rOut
		);
		ctx.fill();

		// Pop the previously saved contexts
		ctx.restore();
	};

	function roundRect( x, y, w, h, r) {
		ctx.beginPath();

		ctx.moveTo( x + r, y);
		ctx.lineTo( x + w - r, y);

		ctx.quadraticCurveTo( x + w, y, x + w, y + r);
		ctx.lineTo( x + w, y + h - r);

		ctx.quadraticCurveTo( x + w, y + h, x + w - r, y + h);
		ctx.lineTo( x + r, y + h);

		ctx.quadraticCurveTo( x, y + h, x, y + h - r);
		ctx.lineTo( x, y + r);

		ctx.quadraticCurveTo( x, y, x + r, y);

		ctx.closePath();
	};
	
	function degreeToCardinal(_value)
	{
		_cardinals = config.cardinals;
		return _cardinals[(Math.floor((_value+22.5/2)/22.5)%16)];
	}
	
	// value box draw
	function drawValueBox() {
		ctx.save();
		
		// Translate the context to move the value box to the center of the [wind, flow...] direction gauge
		if (config.dirGauge) {
			ctx.translate( 0, -max / 100 * 65);
		}
		
		ctx.font = 50 * (max / 200) + "px Arial";

		var
			text = '',
			tw   = ctx.measureText( '-' + padValue( 100)).width,
			y = max - max / 100 * 26,
			x = 0,
			th = 0.12 * max
		;
		if (value != null){
			text = padValue( value);
		}
		if(config.dirGauge && !config.altValue){
			text+='º';
		}
		if(config.altValue){
			text = degreeToCardinal( value);
		}
		ctx.save();

		ctx.restore();

		ctx.fillStyle = "#fff";
		ctx.textAlign = "center";
		ctx.fillText( text, -x, y);

		ctx.restore();
	};
};

// initialize
RadialGauge.initialized = false;
$(document).ready(function(){
		RadialGauge.initialized = true;
});
DRadialGauge = function (container, value, options) 
{
	var gauge = new RadialGauge(container, options); 
	gauge.draw();
	gauge.onready = function() {
		//setInterval( function() { 
			gauge.setValue(value);
		//}, 1000);
	};
}
