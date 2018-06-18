/*
BttrLazyLoading, Responsive Lazy Loading plugin for JQuery
by Julien Renaux http://bttrlazyloading.julienrenaux.fr

Version: 1.0.8

Full source at https://github.com/shprink/BttrLazyLoading

MIT License, https://github.com/shprink/BttrLazyLoading/blob/master/LICENSE
*/
(function() {
  "use strict";
  var $, BttrLazyLoading, BttrLazyLoadingGlobal,
    __hasProp = {}.hasOwnProperty;

  $ = jQuery;

  BttrLazyLoading = (function() {
    var _getImageSrc, _getImgObject, _getImgObjectPerRange, _getLargestImgObject, _getRangeFromScreenSize, _isUpdatable, _isWithinViewport, _setOptionsFromData, _setupEvents, _update, _updateCanvasSize;

    BttrLazyLoading.dpr = 1;

    function BttrLazyLoading(img, options) {
      var defaultOptions;
      if (options == null) {
        options = {};
      }
      this.$img = $(img);
      this.loaded = false;
      this.loading = false;
      defaultOptions = $.extend(true, {}, $.bttrlazyloading.constructor.options);
      this.options = $.extend(true, defaultOptions, options);
      this.breakpoints = $.bttrlazyloading.constructor.breakpoints;
      this.$container = $(this.options.container);
      if (typeof window.devicePixelRatio === 'number') {
        this.constructor.dpr = window.devicePixelRatio;
      }
      this.whiteList = ['lg', 'md', 'sm', 'xs'];
      this.blackList = [];
      _setOptionsFromData.call(this);
      this.$wrapper = $('<span class="bttrlazyloading-wrapper"></span>');
      if (this.options.wrapperClasses && typeof this.options.wrapperClasses === 'string') {
        this.$wrapper.addClass(this.options.wrapperClasses);
      }
      this.$img.before(this.$wrapper);
      this.$clone = $('<canvas class="bttrlazyloading-clone"></canvas>');
      _updateCanvasSize.call(this);
      this.$wrapper.append(this.$clone);
      this.$img.hide();
      this.$wrapper.append(this.$img);
      if (this.options.backgroundcolor) {
        this.$wrapper.css('background-color', this.options.backgroundcolor);
      }
      _setupEvents.call(this, 'on');
      setTimeout((function(_this) {
        return function() {
          return _update.call(_this);
        };
      })(this), 100);
    }


    /*
    	Private Functions
     */

    _updateCanvasSize = function() {
      var imgObject;
      imgObject = _getImgObject.call(this);
      this.$clone.attr('width', imgObject.width);
      return this.$clone.attr('height', imgObject.height);
    };

    _setOptionsFromData = function() {
      var i, v, _ref, _results;
      _ref = this.$img.data();
      _results = [];
      for (i in _ref) {
        if (!__hasProp.call(_ref, i)) continue;
        v = _ref[i];
        if ((v != null) && i.indexOf('bttrlazyloading') !== 0) {
          continue;
        }
        i = i.replace('bttrlazyloading', '').replace(/([a-z])([A-Z])/g, '$1-$2').toLowerCase().split('-');
        if (i.length > 1) {
          if (typeof this.options[i[0]][i[1]] !== 'undefined') {
            _results.push(this.options[i[0]][i[1]] = v);
          } else {
            _results.push(void 0);
          }
        } else {
          if (typeof v === 'object') {
            _results.push($.extend(this.options[i[0]], v));
          } else {
            if (typeof this.options[i[0]] !== 'undefined') {
              _results.push(this.options[i[0]] = v);
            } else {
              _results.push(void 0);
            }
          }
        }
      }
      return _results;
    };

    _setupEvents = function(onOrOff) {
      var onBttrLoad, onError, onLoad, update;
      onLoad = (function(_this) {
        return function() {
          _this.$clone.hide();
          _this.$img.show();
          _this.$wrapper.addClass('bttrlazyloading-loaded');
          if (_this.options.animation) {
            _this.$img.addClass('animated ' + _this.options.animation);
          }
          _this.loaded = _this.$img.attr('src');
          return _this.$img.trigger('bttrlazyloading.afterLoad');
        };
      })(this);
      this.$img[onOrOff]('load', onLoad);
      onBttrLoad = (function(_this) {
        return function(e) {
          var imgObject;
          if (!_this.loading) {
            _this.loading = true;
            imgObject = _getImgObject.call(_this);
            if (!_this.loaded) {
              _this.$wrapper.css('background-image', "url('" + _this.options.placeholder + "')");
            } else {
              _this.$wrapper.removeClass('bttrlazyloading-loaded');
              if (_this.options.animation) {
                _this.$img.removeClass('animated ' + _this.options.animation);
              }
              _this.$img.removeAttr('src');
              _this.$img.hide();
              _this.$clone.attr('width', imgObject.width);
              _this.$clone.attr('height', imgObject.height);
              _this.$clone.show();
            }
            return setTimeout(function() {
              _this.$img.trigger('bttrlazyloading.beforeLoad');
              _this.$img.data('bttrlazyloading.range', imgObject.range);
              _this.$img.attr('src', _getImageSrc.call(_this, imgObject.src, imgObject.range));
              return _this.loading = false;
            }, _this.options.delay);
          }
        };
      })(this);
      this.$img[onOrOff]('bttrlazyloading.load', onBttrLoad);
      onError = (function(_this) {
        return function(e) {
          var range, src;
          src = _this.$img.attr('src');
          range = _this.$img.data('bttrlazyloading.range');
          if (_this.constructor.dpr >= 2 && _this.options.retina && src.match(/@2x/gi)) {
            _this.blackList.push(range + '@2x');
          } else {
            _this.blackList.push(range);
            _this.whiteList.splice(_this.whiteList.indexOf(range), 1);
            if (_this.whiteList.length === 0) {
              _this.$img.trigger('bttrlazyloading.error');
              return false;
            }
          }
          return _this.$img.trigger('bttrlazyloading.load');
        };
      })(this);
      this.$img[onOrOff]('error', onError);
      update = (function(_this) {
        return function(e) {
          return _update.call(_this);
        };
      })(this);
      this.$container[onOrOff](this.options.event, update);
      if (this.options.container !== window) {
        $(window)[onOrOff](this.options.event, update);
      }
      return $(window)[onOrOff]("resize", update);
    };

    _getRangeFromScreenSize = function() {
      var ww;
      ww = window.innerWidth;
      if (ww <= this.breakpoints.xs) {
        return 'xs';
      } else if ((this.breakpoints.sm <= ww && ww < this.breakpoints.md)) {
        return 'sm';
      } else if ((this.breakpoints.md <= ww && ww < this.breakpoints.lg)) {
        return 'md';
      } else if (this.breakpoints.lg <= ww) {
        return 'lg';
      }
    };

    _getImgObject = function() {
      this.range = _getRangeFromScreenSize.call(this);
      return _getLargestImgObject.call(this);
    };

    _getImageSrc = function(src, range) {
      if (this.constructor.dpr >= 2 && this.options.retina && this.blackList.indexOf(range + '@2x') === -1) {
        return src.replace(/\.\w+$/, function(match) {
          return '@2x' + match;
        });
      } else {
        return src;
      }
    };

    _getImgObjectPerRange = function(range) {
      if (typeof this.options[range].src !== 'undefined' && this.options[range].src !== null) {
        return this.options[range];
      }
      return null;
    };

    _getLargestImgObject = function() {
      var index, range, src, _i, _len, _ref;
      index = this.whiteList.indexOf(this.range);
      if (index > -1) {
        src = _getImgObjectPerRange.call(this, this.range);
        if (src) {
          src.range = this.range;
          return src;
        }
      }
      _ref = this.whiteList;
      for (index = _i = 0, _len = _ref.length; _i < _len; index = ++_i) {
        range = _ref[index];
        src = _getImgObjectPerRange.call(this, range);
        if (src) {
          src.range = range;
          return src;
        }
      }
      return '';
    };

    _isUpdatable = function() {
      var imgObject, isWithinWindowViewport, threshold;
      if (!this.loaded && this.options.triggermanually) {
        return false;
      }
      if (this.loaded && this.options.updatemanually) {
        return false;
      }
      imgObject = _getImgObject.call(this);
      if (!imgObject.src || this.loaded === _getImageSrc.call(this, imgObject.src, imgObject.range)) {
        return false;
      }
      threshold = 0;
      if (!this.loaded) {
        threshold = this.options.threshold;
      }
      isWithinWindowViewport = _isWithinViewport.call(this, $(window), {
        top: $(window).scrollTop() + threshold,
        left: $(window).scrollLeft()
      });
      if (this.options.container !== window) {
        return isWithinWindowViewport && _isWithinViewport.call(this, this.$container, {
          top: this.$container.offset().top + threshold,
          left: this.$container.offset().left
        });
      }
      return isWithinWindowViewport;
    };

    _isWithinViewport = function($container, viewport) {
      var bounds;
      if (viewport == null) {
        viewport = {};
      }
      viewport.right = viewport.left + $container.width();
      viewport.bottom = viewport.top + $container.height();
      bounds = this.$wrapper.offset();
      bounds.right = bounds.left + this.$wrapper.outerWidth();
      bounds.bottom = bounds.top + this.$wrapper.outerHeight();
      return !(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom);
    };

    _update = function() {
      if (this.range !== _getRangeFromScreenSize.call(this)) {
        _updateCanvasSize.call(this);
      }
      if (_isUpdatable.call(this)) {
        return this.$img.trigger('bttrlazyloading.load');
      }
    };


    /*
    	Public Functions
     */

    BttrLazyLoading.prototype.get$Img = function() {
      return this.$img;
    };

    BttrLazyLoading.prototype.get$Clone = function() {
      return this.$clone;
    };

    BttrLazyLoading.prototype.get$Wrapper = function() {
      return this.$wrapper;
    };

    BttrLazyLoading.prototype.destroy = function() {
      this.$wrapper.before(this.$img);
      this.$wrapper.remove();
      _setupEvents.call(this, 'off');
      this.$img.off('bttrlazyloading');
      this.$wrapper.removeClass('bttrlazyloading-loaded');
      if (this.options.animation) {
        this.$img.removeClass('animated ' + this.options.animation);
      }
      this.$img.removeData('bttrlazyloading');
      return this.$img;
    };

    return BttrLazyLoading;

  })();

  $.fn.extend({
    bttrlazyloading: function(options) {
      return this.each(function() {
        var $this, data;
        $this = $(this);
        data = $this.data('bttrlazyloading');
        if (typeof data === 'undefined') {
          data = new BttrLazyLoading(this, options);
          $this.data('bttrlazyloading', data);
        }
        if (typeof options === 'string' && typeof data[options] !== 'undefined') {
          return data[options].call(data);
        }
      });
    }
  });

  $.fn.bttrlazyloading.Constructor = BttrLazyLoading;

  BttrLazyLoadingGlobal = (function() {
    function BttrLazyLoadingGlobal() {}

    BttrLazyLoadingGlobal.prototype.version = '1.0.8';

    BttrLazyLoadingGlobal.breakpoints = {
      xs: 767,
      sm: 768,
      md: 992,
      lg: 1200
    };

    BttrLazyLoadingGlobal.options = {
      xs: {
        src: null,
        width: 100,
        height: 100,
        animation: null
      },
      sm: {
        src: null,
        width: 100,
        height: 100,
        animation: null
      },
      md: {
        src: null,
        width: 100,
        height: 100,
        animation: null
      },
      lg: {
        src: null,
        width: 100,
        height: 100,
        animation: null
      },
      retina: false,
      animation: 'bounceIn',
      delay: 0,
      event: 'scroll',
      container: window,
      threshold: 0,
      triggermanually: false,
      updatemanually: false,
      wrapperClasses: null,
      backgroundcolor: '#EEE',
      placeholder: 'data:image/gif;base64,R0lGODlhQABAANU2APb29vz8/O7u7vv7++bm5q6urvn5+d7e3vj4+NbW1r6+vra2ts7OzsbGxvT09PPz8/Hx8aurq/Dw8Ovr6+zs7KysrOTk5OPj4+np6ejo6ODg4LCwsOHh4bGxsbS0tLOzs9nZ2bi4uNPT07m5udTU1Nzc3Lu7u8DAwMvLy9jY2Ly8vNvb29HR0cnJycPDw9DQ0MHBwcjIyMTExMzMzP7+/v///////wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH/C05FVFNDQVBFMi4wAwEAAAAh/wtYTVAgRGF0YVhNUDw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNS1jMDIxIDc5LjE1NTc3MiwgMjAxNC8wMS8xMy0xOTo0NDowMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTQgKE1hY2ludG9zaCkiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6QkU0MkQ3RjkwODkxMTFFNTkyNkVDMTBGODVDQUFCNzciIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6QkU0MkQ3RkEwODkxMTFFNTkyNkVDMTBGODVDQUFCNzciPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpCRTQyRDdGNzA4OTExMUU1OTI2RUMxMEY4NUNBQUI3NyIg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'    	  };

    BttrLazyLoadingGlobal.prototype.setOptions = function(object) {
      if (object == null) {
        object = {};
      }
      $.extend(true, this.constructor.options, object);
      return this;
    };

    BttrLazyLoadingGlobal.prototype.setRanges = function(object) {
      if (object == null) {
        object = {};
      }
      $.extend(true, this.constructor.breakpoints, object);
      return this;
    };

    BttrLazyLoadingGlobal.prototype.setBreakPoints = function(object) {
      if (object == null) {
        object = {};
      }
      $.extend(true, this.constructor.breakpoints, object);
      return this;
    };

    return BttrLazyLoadingGlobal;

  })();

  $.bttrlazyloading = new BttrLazyLoadingGlobal();

}).call(this);
