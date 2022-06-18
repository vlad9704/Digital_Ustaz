/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./src/resources/js/common.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/resources/js/common.js":
/*!************************************!*\
  !*** ./src/resources/js/common.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("// import \"./components/form-input\";\n// Touch Detect\nfunction isTouch() {\n  try {\n    document.createEvent(\"TouchEvent\");\n    return true;\n  } catch (e) {\n    return false;\n  }\n}\n\nif (isTouch()) $('html').addClass('is-touch');\n$(function () {\n  $(\".link-scroll\").on(\"click\", function (e) {\n    // var windowWidth = $(window).outerWidth();\n    if (this.hash !== \"\") {\n      e.preventDefault();\n      var hash = this.hash;\n      $('html, body').animate({\n        scrollTop: $(hash).offset().top\n      }, 800, function () {\n        window.location.hash = hash;\n      });\n    }\n\n    if ($(this).hasClass('scrollJsMenu')) {\n      closeMobileMenu();\n    }\n  }); // меню ЛК\n\n  $(\".header-auth-js\").on(\"click\", function (evnLk) {\n    evnLk.preventDefault();\n    var thas = $(this);\n    var lkPanel = $(thas).closest('.header-block__auth').find('.header-panel');\n\n    if (!$(thas).hasClass('is-active')) {\n      $(lkPanel).slideDown('slow', function () {\n        $(thas).addClass('is-active');\n      });\n    } else {\n      $(lkPanel).slideUp('slow', function () {\n        $(thas).removeClass('is-active');\n      });\n    }\n  }); //- show menu mobile\n\n  $(\".touch-nav-js\").on(\"click\", function (e) {\n    e.preventDefault();\n\n    if (!$(this).hasClass('is-active')) {\n      $(this).addClass('is-active');\n      $(\"html\").addClass(\"htmlFix\");\n      $(\"body\").addClass(\"navFix\");\n      $(\".nav-block__mobile\").show();\n    } else {\n      $(this).removeClass('is-active');\n      $(\"html\").removeClass(\"htmlFix\");\n      $(\"body\").removeClass(\"navFix\");\n      $(\".nav-block__mobile\").hide();\n    }\n  });\n  $(\"body\").on(\"click\", '.btn-open-modal', function (e) {\n    // e.preventDefault();\n    $.fancybox.close();\n    var modalId = $(this).attr(\"href\");\n    setTimeout(function () {\n      $.fancybox.open({\n        src: modalId\n      });\n    }, 400);\n  }); // смена языка\n\n  $(\".lang-js\").on(\"click\", function (e) {\n    e.preventDefault();\n    var thas = $(this);\n    var langBlock = $(thas).parent().find('.dropdown-lang');\n\n    if (!$(thas).hasClass('is-active')) {\n      $(langBlock).slideDown('slow', function () {\n        $(thas).addClass('is-active');\n      });\n    } else {\n      $(langBlock).slideUp('slow', function () {\n        $(thas).removeClass('is-active');\n      });\n    }\n  });\n}); //- end \n// 222222222\n\nfunction closeMobileMenu() {\n  $('.touch-nav-js').removeClass('is-active');\n  $(\"html\").removeClass(\"htmlFix\");\n  $(\"body\").removeClass(\"navFix\");\n  $(\".nav-block__mobile\").hide();\n}\n\nfunction sliderInit(slider, params) {\n  $('.' + slider).slick(params);\n}\n\nfunction sliderDestroy(slider) {\n  $('.' + slider).slick('unslick');\n}\n\nfunction isHighDensity() {\n  return window.matchMedia && (window.matchMedia('only screen and (min-resolution: 124dpi), only screen and (min-resolution: 1.3dppx), only screen and (min-resolution: 48.8dpcm)').matches || window.matchMedia('only screen and (-webkit-min-device-pixel-ratio: 1.3), only screen and (-o-min-device-pixel-ratio: 2.6/2), only screen and (min--moz-device-pixel-ratio: 1.3), only screen and (min-device-pixel-ratio: 1.3)').matches) || window.devicePixelRatio && window.devicePixelRatio > 1.3;\n}\n\nfunction isRetina() {\n  return (window.matchMedia && (window.matchMedia('only screen and (min-resolution: 192dpi), only screen and (min-resolution: 2dppx), only screen and (min-resolution: 75.6dpcm)').matches || window.matchMedia('only screen and (-webkit-min-device-pixel-ratio: 2), only screen and (-o-min-device-pixel-ratio: 2/1), only screen and (min--moz-device-pixel-ratio: 2), only screen and (min-device-pixel-ratio: 2)').matches) || window.devicePixelRatio && window.devicePixelRatio > 2) && /(iPad|iPhone|iPod)/g.test(navigator.userAgent);\n}\n\nfunction retinaImagesBox(box, retina) {\n  if (retina == '2x') {\n    var imgPath2x = $(box).attr('data-2x');\n    $(box).css({\n      'backgroundImage': 'url(' + imgPath2x + ')'\n    });\n    return false;\n  }\n\n  if (retina == '1x') {\n    var imgPath1x = $(box).attr('data-1x');\n    $(box).css({\n      'backgroundImage': 'url(' + imgPath1x + ')'\n    });\n    return false;\n  }\n}\n\ntry {} catch (e) {}\n\nfunction loadPage() {\n  var windowWidth = $(window).outerWidth();\n\n  try {\n    if ($('.speakerImg')) {\n      if (isRetina() || isHighDensity()) {\n        $('.speakerImg').each(function () {\n          retinaImagesBox($(this), '2x');\n        });\n        return false;\n      } else {\n        $('.speakerImg').each(function () {\n          retinaImagesBox($(this), '1x');\n        });\n        return false;\n      }\n    }\n  } catch (e) {}\n} //end loadPage\n\n\nwindow.addEventListener(\"load\", loadPage);\n\nfunction resizePage() {\n  var windowWidth = $(window).outerWidth();\n\n  if (windowWidth >= 1024) {\n    $(\".nav-block__mobile\").removeAttr('style');\n    $('.touch-nav').removeClass('is-active');\n    $('html').removeClass('htmlFix');\n    $('body').removeClass('navFix');\n  }\n} //end resizePage\n\n\nwindow.addEventListener(\"resize\", resizePage);\n\n//# sourceURL=webpack:///./src/resources/js/common.js?");

/***/ })

/******/ });