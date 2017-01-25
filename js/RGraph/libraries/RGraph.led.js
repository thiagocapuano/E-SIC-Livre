// version: 2014-08-16
    /**
    * o--------------------------------------------------------------------------------o
    * | This file is part of the RGraph package - you can learn more at:               |
    * |                                                                                |
    * |                          http://www.rgraph.net                                 |
    * |                                                                                |
    * | This package is licensed under the Creative Commons BY-NC license. That means  |
    * | that for non-commercial purposes it's free to use and for business use there's |
    * | a 99 GBP per-company fee to pay. You can read the full license here:           |
    * |                                                                                |
    * |                      http://www.rgraph.net/license                             |
    * o--------------------------------------------------------------------------------o
    */

    RGraph = window.RGraph || {isRGraph: true};

    /**
    * The LED lights constructor
    * 
    * @param object canvas The canvas object
    * @param array  data   The chart data
    */
    RGraph.LED = function (conf)
    {
        /**
        * Allow for object config style
        */
        if (   typeof conf === 'object'
            && typeof conf.text === 'string'
            && typeof conf.id === 'string') {

            var id                        = conf.id
            var canvas                    = document.getElementById(id);
            var text                      = conf.text;
            var parseConfObjectForOptions = true; // Set this so the config is parsed (at the end of the constructor)
        
        } else {
        
            var id     = conf;
            var canvas = document.getElementById(id);
            var text   = arguments[1];
        }



        this.id                = id;
        this.canvas            = canvas;
        this.context           = this.canvas.getContext ? this.canvas.getContext("2d", {alpha: (typeof id === 'object' && id.alpha === false) ? false : true}) : null;
        this.canvas.__object__ = this;
        this.type              = 'led';
        this.isRGraph          = true;
        this.uid               = RGraph.CreateUID();
        this.canvas.uid        = this.canvas.uid ? this.canvas.uid : RGraph.CreateUID();
        this.colorsParsed      = false;
        this.original_colors   = [];
        this.firstDraw         = true; // After the first draw this will be false


        /**
        * Compatibility with older browsers
        */
        //RGraph.OldBrowserCompat(this.context);


        /**
        * Set the string that is to be displayed
        */
        this.text = text.toLowerCase();
        
        /**
        * The letters and numbers
        */
        this.lights = {
            '#': [[1,1,1,1],[1,1,1,1],[1,1,1,1],[1,1,1,1],[1,1,1,1],[1,1,1,1],[1,1,1,1]],
            '-': [[0,0,0,0],[0,0,0,0],[0,0,0,0],[1,1,1,1],[0,0,0,0],[0,0,0,0],[0,0,0,0]],
            '_': [[0,0,0,0],[0,0,0,0],[0,0,0,0],[0,0,0,0],[0,0,0,0],[0,0,0,0],[1,1,1,1]],
            '*': [[0,0,0,0],[0,0,0,0],[1,0,0,1],[0,1,1,0],[0,1,1,0],[1,0,0,1],[0,0,0,0]],
            '<': [[0,0,0,1],[0,0,1,0],[0,1,0,0],[1,0,0,0],[0,1,0,0],[0,0,1,0],[0,0,0,1]],
            '>': [[1,0,0,0],[0,1,0,0],[0,0,1,0],[0,0,0,1],[0,0,1,0],[0,1,0,0],[1,0,0,0]],
            '%': [[0,0,0,0],[0,0,0,0],[1,0,0,1],[0,0,1,0],[0,1,0,0],[1,0,0,1],[0,0,0,0]],
            '¡': [[0,0,1,0],[0,0,0,0],[0,0,1,0],[0,0,1,0],[0,0,1,0],[0,0,1,0],[0,0,1,0]],
            '!': [[0,0,1,0],[0,0,1,0],[0,0,1,0],[0,0,1,0],[0,0,1,0],[0,0,0,0],[0,0,1,0]],
            '¿': [[0,0,1,0],[0,0,0,0],[0,0,1,0],[0,1,1,0],[1,0,0,0],[1,0,0,0],[0,1,1,1]],
            '?': [[1,1,1,0],[0,0,0,1],[0,0,0,1],[0,1,1,0],[0,1,0,0],[0,0,0,0],[0,1,0,0]],
            '+': [[0,0,0,0],[0,0,0,0],[0,1,0,0],[1,1,1,0],[0,1,0,0],[0,0,0,0],[0,0,0,0]],
            '/': [[0,0,0,0],[0,0,0,1],[0,0,1,0],[0,1,0,0],[1,0,0,0],[0,0,0,0],[0,0,0,0]],
            ',': [[0,0,0,0],[0,0,0,0],[0,0,0,0],[0,0,0,0],[0,0,0,0],[0,0,1,0],[0,1,0,0]],
            '.': [[0,0,0,0],[0,0,0,0],[0,0,0,0],[0,0,0,0],[0,0,0,0],[0,0,0,0],[0,1,0,0]],
            ';': [[0,0,0,0],[0,0,0,0],[0,0,0,0],[0,0,1,0],[0,0,0,0],[0,0,1,0],[0,1,0,0]],
            ':': [[0,0,0,0],[0,0,0,0],[0,1,0,0],[0,0,0,0],[0,1,0,0],[0,0,0,0],[0,0,0,0]],
            '"': [[1,0,1,0],[1,0,1,0],[0,0,0,0],[0,0,0,0],[0,0,0,0],[0,0,0,0],[0,0,0,0]],
            '[': [[1,1,1,0],[1,0,0,0],[1,0,0,0],[1,0,0,0],[1,0,0,0],[1,0,0,0],[1,1,1,0]],
            ']': [[0,1,1,1],[0,0,0,1],[0,0,0,1],[0,0,0,1],[0,0,0,1],[0,0,0,1],[0,1,1,1]],
            '(': [[0,0,1,1],[0,1,1,0],[0,1,0,0],[0,1,0,0],[0,1,0,0],[0,1,1,0],[0,0,1,1]],
            ')': [[1,1,0,0],[0,1,1,0],[0,0,1,0],[0,0,1,0],[0,0,1,0],[0,1,1,0],[1,1,0,0]],
            'R': [[1,0,0,0],[1,1,0,0],[1,1,1,0],[1,1,1,1],[1,1,1,0],[1,1,0,0],[1,0,0,0]],
            'L': [[0,0,0,1],[0,0,1,1],[0,1,1,1],[1,1,1,1],[0,1,1,1],[0,0,1,1],[0,0,0,1]],
            'a': [[0,1,1,0],[1,0,0,1],[1,0,0,1],[1,1,1,1],[1,0,0,1],[1,0,0,1],[1,0,0,1]],
            'b': [[1,1,1,0],[1,0,0,1],[1,0,0,1],[1,1,1,0],[1,0,0,1],[1,0,0,1],[1,1,1,0]],
            'c': [[0,1,1,0],[1,0,0,1],[1,0,0,0],[1,0,0,0],[1,0,0,0],[1,0,0,1],[0,1,1,0]],
            'd': [[1,1,1,0],[1,0,0,1],[1,0,0,1],[1,0,0,1],[1,0,0,1],[1,0,0,1],[1,1,1,0]],
            'e': [[1,1,1,1],[1,0,0,0],[1,0,0,0],[1,1,1,0],[1,0,0,0],[1,0,0,0],[1,1,1,1]],
            'f': [[1,1,1,1],[1,0,0,0],[1,0,0,0],[1,1,1,0],[1,0,0,0],[1,0,0,0],[1,0,0,0]],
            'g': [[0,1,1,0],[1,0,0,1],[1,0,0,0],[1,0,1,1],[1,0,0,1],[1,0,0,1],[0,1,1,0]],
            'h': [[1,0,0,1],[1,0,0,1],[1,0,0,1],[1,1,1,1],[1,0,0,1],[1,0,0,1],[1,0,0,1]],
            'i': [[0,1,1,1],[0,0,1,0],[0,0,1,0],[0,0,1,0],[0,0,1,0],[0,0,1,0],[0,1,1,1]],
            'j': [[0,1,1,1],[0,0,1,0],[0,0,1,0],[0,0,1,0],[0,0,1,0],[0,0,1,0],[0,1,0,0]],
            'k': [[1,0,0,1],[1,0,0,1],[1,0,1,0],[1,1,0,0],[1,0,1,0],[1,0,0,1],[1,0,0,1]],
            'l': [[1,0,0,0],[1,0,0,0],[1,0,0,0],[1,0,0,0],[1,0,0,0],[1,0,0,0],[1,1,1,1]],
            'm': [[1,0,0,1],[1,1,1,1],[1,0,0,1],[1,0,0,1],[1,0,0,1],[1,0,0,1],[1,0,0,1]],
            'n': [[1,0,0,1],[1,1,0,1],[1,0,1,1],[1,0,0,1],[1,0,0,1],[1,0,0,1],[1,0,0,1]],
            'o': [[0,1,1,0],[1,0,0,1],[1,0,0,1],[1,0,0,1],[1,0,0,1],[1,0,0,1],[0,1,1,0]],
            'p': [[1,1,1,0],[1,0,0,1],[1,0,0,1],[1,1,1,0],[1,0,0,0],[1,0,0,0],[1,0,0,0]],
            'q': [[0,1,1,0],[1,0,0,1],[1,0,0,1],[1,0,0,1],[1,0,0,1],[1,0,1,1],[0,1,1,1]],
            'r': [[1,1,1,0],[1,0,0,1],[1,0,0,1],[1,1,1,0],[1,0,1,0],[1,0,0,1],[1,0,0,1]],
            's': [[0,1,1,0],[1,0,0,1],[1,0,0,0],[0,1,1,0],[0,0,0,1],[1,0,0,1],[0,1,1,0]],
            't': [[1,1,1,0],[0,1,0,0],[0,1,0,0],[0,1,0,0],[0,1,0,0],[0,1,0,0],[0,1,0,0]],
            'u': [[1,0,0,1],[1,0,0,1],[1,0,0,1],[1,0,0,1],[1,0,0,1],[1,0,0,1],[0,1,1,0]],
            'v': [[1,0,1],[1,0,1],[1,0,1],[1,0,1],[1,0,1],[0,1,0],[0,1,0]],
            'w': [[1,0,0,1],[1,0,0,1],[1,0,0,1],[1,0,0,1],[1,0,0,1],[1,1,1,1],[0,1,1,0]],
            'x': [[0,1,0,1],[0,1,0,1],[0,1,0,1],[0,0,1,0],[0,1,0,1],[0,1,0,1],[0,1,0,1]],
            'y': [[0,1,0,1],[0,1,0,1],[0,0,1,0],[0,0,1,0],[0,0,1,0],[0,0,1,0],[0,0,1,0]],
            'z': [[1,1,1,1],[0,0,0,1],[0,0,1,0],[0,0,1,0],[0,1,0,0],[1,0,0,0],[1,1,1,1]],
            ' ': [[],[],[],[],[], [], []],
            '0': [[0,1,1,0],[1,0,0,1],[1,0,0,1],[1,0,0,1],[1,0,0,1],[1,0,0,1],[0,1,1,0]],
            '1': [[0,0,1,0],[0,1,1,0],[0,0,1,0],[0,0,1,0],[0,0,1,0],[0,0,1,0],[0,1,1,1]],
            '2': [[0,1,1,0],[1,0,0,1],[0,0,0,1],[0,0,1,0],[0,1,,0],[1,0,0,0],[1,1,1,1]],
            '3': [[0,1,1,0],[1,0,0,1],[0,0,0,1],[0,1,1,0],[0,0,0,1],[1,0,0,1],[0,1,1,0]],
            '4': [[1,0,0,0],[1,0,0,0],[1,0,1,0],[1,0,1,0],[1,1,1,1],[0,0,1,0],[0,0,1,0]],
            '5': [[1,1,1,1],[1,0,0,0],[1,0,0,0],[1,1,1,0],[0,0,0,1],[1,0,0,1],[0,1,1,0]],
            '6': [[0,1,1,0],[1,0,0,1],[1,0,0,0],[1,1,1,0],[1,0,0,1],[1,0,0,1],[0,1,1,0]],
            '7': [[1,1,1,1],[0,0,0,1],[0,0,0,1],[0,0,1,0],[0,1,0,0],[0,1,0,0],[0,1,0,0]],
            '8': [[0,1,1,0],[1,0,0,1],[1,0,0,1],[0,1,1,0],[1,0,0,1],[1,0,0,1],[0,1,1,0]],
            '9': [[0,1,1,1],[1,0,0,1],[1,0,0,1],[0,1,1,1],[0,0,0,1],[0,0,0,1],[0,0,0,1]]
        }

        // Various config type stuff
        this.properties =
        {
            'chart.dark':          '#eee',
            'chart.light':         '#f66',
            'chart.tooltips':      null,
            'chart.zoom.factor':   1.5,
            'chart.zoom.fade.in':  true,
            'chart.zoom.fade.out': true,
            'chart.zoom.hdir':     'right',
            'chart.zoom.vdir':     'down',
            'chart.zoom.frames':   25,
            'chart.zoom.delay':    16.666,
            'chart.zoom.shadow':   true,
            'chart.zoom.background': true,
            'chart.zoom.action':     'zoom',
            'chart.resizable':              false,
            'chart.resize.handle.adjust':   [0,0],
            'chart.resize.handle.background': null,
            'chart.radius':                   null
        }

        
        
        

        
        
        
        
        
        // Check for support
        if (!this.canvas) {
            alert('[LED] No canvas support');
            return;
        }



        /*
        * Translate half a pixel for antialiasing purposes - but only if it hasn't beeen
        * done already
        */
        if (!this.canvas.__rgraph_aa_translated__) {
            this.context.translate(0.5,0.5);
            
            this.canvas.__rgraph_aa_translated__ = true;
        }



        
        // Short variable names
        var RG   = RGraph;
        var ca   = this.canvas;
        var co   = ca.getContext('2d');
        var prop = this.properties;
        var jq   = jQuery;
        var pa   = RG.Path;
        var win  = window;
        var doc  = document;
        var ma   = Math;
        
        
        
        /**
        * "Decorate" the object with the generic effects if the effects library has been included
        */
        if (RG.Effects && typeof RG.Effects.decorate === 'function') {
            RG.Effects.decorate(this);
        }





        /**
        * A setter
        * 
        * @param name  string The name of the property to set
        * @param value mixed  The value of the property
        */
        this.set =
        this.Set = function (name)
        {
            var value = typeof arguments[1] === 'undefined' ? null : arguments[1];

            /**
            * the number of arguments is only one and it's an
            * object - parse it for configuration data and return.
            */
            if (arguments.length === 1 && typeof name === 'object') {
                RG.parseObjectStyleConfig(this, name);
                return this;
            }


            name = name.toLowerCase();
    
            /**
            * This should be done first - prepend the propertyy name with "chart." if necessary
            */
            if (name.substr(0,6) != 'chart.') {
                name = 'chart.' + name;
            }
    
            prop[name.toLowerCase()] = value;
    
            return this;
        };




        /**
        * A getter
        * 
        * @param name  string The name of the property to get
        */
        this.get =
        this.Get = function (name)
        {
            /**
            * This should be done first - prepend the property name with "chart." if necessary
            */
            if (name.substr(0,6) != 'chart.') {
                name = 'chart.' + name;
            }
    
            return prop[name.toLowerCase()];
        };




        /**
        * This draws the LEDs
        */
        this.draw =
        this.Draw = function ()
        {
            /**
            * Fire the onbeforedraw event
            */
            RG.FireCustomEvent(this, 'onbeforedraw');
    
    
            /**
            * Parse the colors. This allows for simple gradient syntax
            */
            if (!this.colorsParsed) {
    
                this.parseColors();
                
                // Don't want to do this again
                this.colorsParsed = true;
            }
    

            
            for (var l=0,len=this.text.length; l<len; l++) {
                this.DrawLetter(this.text.charAt(l), l);
            }
            
            /**
            * Set the title attribute on the canvas
            */
            ca.title = RG.rtrim(this.text);
    
            /**
            * Setup the context menu if required
            */
            if (prop['chart.contextmenu']) {
                RG.ShowContext(this);
            }
    
            
            /**
            * This function enables resizing
            */
            if (prop['chart.resizable']) {
                RG.AllowResizing(this);
            }
    
    
            /**
            * This installs the event listeners
            */
            RG.InstallEventListeners(this);

            /**
            * Fire the onfirstdraw event
            */
            if (this.firstDraw) {
                RG.fireCustomEvent(this, 'onfirstdraw');
                this.firstDraw = false;
                this.firstDrawFunc();
            }

            /**
            * Fire the RGraph ondraw event
            */
            RG.FireCustomEvent(this, 'ondraw');
            
            return this;
        };




        /**
        * Draws a single letter
        * 
        * @param string lights The lights to draw to draw
        * @param int    index  The position of the letter
        */
        this.drawLetter =
        this.DrawLetter = function (letter, index)
        {
            var light    = prop['chart.light'];
            var dark     = prop['chart.dark'];
            var lights   = (this.lights[letter] ? this.lights[letter] : [[0,0,0,0,0],[0,0,0,0,0],[0,0,0,0,0],[0,0,0,0,0],[0,0,0,0,0],[0,0,0,0,0],[0,0,0,0,0]]);
    
    
            /**
            * Now allow user specified radius of the size of the lights
            */
            if (typeof(prop['chart.radius']) == 'number') {
                radius = Number(prop['chart.radius']);
                diameter = 2 * radius;
                lwidth   = diameter * 5;
            } else {
                var radius   = ((ca.width / this.text.length) / 5) / 2;
                var diameter = radius * 2;
                var lwidth   = diameter * 5;
            }

            //var lheight = diameter * 7;
            //if (lheight > ca.height) {
            //    lheight  = ca.height;
            //    diameter = (lheight / 7);
            //    radius   = (diameter / 2);
            //    lwidth   = diameter * 5;
            //}
    
            for (var i=0; i<7; i++) {
                for (var j=0; j<5; j++) {
    
                    var x = (j * diameter) + (index * lwidth) + radius;
                    var y = ((i * diameter)) + radius;
    
                    // Draw a circle
                    co.fillStyle   = (lights[i][j] ? light : dark);
                    co.strokeStyle = (lights[i][j] ? '#ccc' : 'rgba(0,0,0,0)');
                    co.beginPath();
                    co.arc(x, y, radius, 0, RG.TWOPI, 0);
    
                    co.stroke();
                    co.fill();
                }
            }
        };




        /**
        * A place holder
        * 
        * @param object e The event object
        */
        this.getValue = function (e)
        {
            return this.text;
        };




        /**
        * This allows for easy specification of gradients
        */
        this.parseColors = function ()
        {
            // Save the original colors so that they can be restored when the canvas is reset
            if (this.original_colors.length === 0) {
                this.original_colors['chart.dark']  = RG.array_clone(prop['chart.dark']);
                this.original_colors['chart.light'] = RG.array_clone(prop['chart.light']);
            }

            prop['chart.dark'] = this.parseSingleColorForGradient(prop['chart.dark']);
            prop['chart.light'] = this.parseSingleColorForGradient(prop['chart.light']);
        };




        /**
        * Use this function to reset the object to the post-constructor state. Eg reset colors if
        * need be etc
        */
        this.reset = function ()
        {
        };




        /**
        * This parses a single color value
        */
        this.parseSingleColorForGradient = function (color)
        {
            if (typeof color === 'string' && color.match(/^gradient\((.*)\)$/i)) {
    
                var parts = RegExp.$1.split(':');

                // Create the gradient
                var grad = co.createLinearGradient(0,0,0,ca.height);
    
                var diff = 1 / (parts.length - 1);
    
                grad.addColorStop(0, RG.trim(parts[0]));
    
                for (var j=1; j<parts.length; ++j) {
                    grad.addColorStop(j * diff, RG.trim(parts[j]));
                }
            }

            return grad ? grad : color;
        };




        /**
        * Using a function to add events makes it easier to facilitate method chaining
        * 
        * @param string   type The type of even to add
        * @param function func 
        */
        this.on = function (type, func)
        {
            if (type.substr(0,2) !== 'on') {
                type = 'on' + type;
            }
            
            this[type] = func;
    
            return this;
        };




        /**
        * This function runs once only
        * (put at the end of the file (before any effects))
        */
        this.firstDrawFunc = function ()
        {
        };
        
        
        
        
        /**
        * A placeholder
        */
        this.getObjectByXY = function ()
        {
        }




        RG.Register(this);




        /**
        * This is the 'end' of the constructor so if the first argument
        * contains configuration data - handle that.
        */
        if (parseConfObjectForOptions) {
            RG.parseObjectStyleConfig(this, conf.options);
        }
    };