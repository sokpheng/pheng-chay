/*
 * @Team: Flexitech
 * @Author: panhna
 * @Date:   Sat Nov 26 2016 00:51:25
 * @Last Modified by:   panhna
 * @Last Modified time: Sat Nov 26 2016 00:51:25
 */

(function() {

    app.service('hhModule', ['$http', '$rootScope', '$window', 'genfunc', function($http, $rootScope, $window, genfunc) {

        function getRandom(min, max) {
            return min + Math.floor(Math.random() * (max - min + 1));
        }

        // console.log(genfunc.getLang());

        var public_method = {

            getDollarSimbol: function(price_rate_val) {

                var price_rate = '';
                for (var i=1; i<=price_rate_val; i++) { 
                    price_rate += '$';
                }
                if(price_rate == '')
                    price_rate = '$$$';

                return price_rate;

            },

            getStarRate: function(rate_val) {

                var _ranNum = getRandom(2, 10);
                var _rateCount = rate_val ? rate_val : _ranNum;
                _rateCount = _rateCount % 5;
                return _rateCount;

            },

            getRatePoint: function(rate_point_val) {
                return Math.round(rate_point_val);

            },
            formatDistance: function(distance){
                if(distance<1000){
                    //var km =  Math.round(distance * 100) / 100;
                    // var km =  ;
                    return Math.round(distance) + ' m';
                }else{
                    var km =  Math.round(distance / 1000*100) /100;
                    return km  + ' km';
                }
            },
            controllMenu: function(type){
                if(type == '#/post') {
                    $(".open-post").tab('show');
                }else if(type == '#/photo'){
                    $(".open-photo").tab('show');
                }else if(type == '#/save'){
                    $(".open-save").tab('show'); 
                }else if(type == '#/setting'){
                    $(".open-setting").tab('show');
                }
            },
            getRestCover: function($restItem){
                // console.log($restItem);
                var _imgObj = {
                    src: '/img/comp/restaurant-logo.png',
                    bg_cls: 'bg-normal',
                };
                if($restItem.logo){
                    if($restItem.logo.thumbnail_url_link){
                       _imgObj.src = $restItem.logo.thumbnail_url_link;
                       _imgObj.bg_cls = 'bg-cover';
                    }
                }
                if($restItem.cover){
                    if($restItem.cover.thumbnail_url_link){
                        _imgObj.src = $restItem.cover.thumbnail_url_link;
                        _imgObj.bg_cls = 'bg-cover';

                    }
                }
                return _imgObj;
            },

            getProfilePic: function($restItem){

                var _profile = genfunc.getUser().profile;
                var _photo = '';
                // console.log(_profile);
                if(_profile.photo){
                    if(_profile.photo.thumbnail_url_link){
                        _photo = _profile.photo.thumbnail_url_link;
                    }
                }

                return _photo;
            },

            // get language translate from locale json string in category obj
            getLangCate: function(obj, field){

                // console.log(obj,field);

                lang = genfunc.getLang();

                if(obj && obj['locale']){

                    var cateObj=obj['locale'];

                    if(cateObj && cateObj[lang]){
                        if(cateObj[lang][field] && cateObj[lang][field] != '')
                            return cateObj[lang][field];
                        else
                            return obj[field];
                    }
                    else{
                        return obj[field];
                    }
                }
                else{
                    // console.log(obj[field]);
                    return obj[field];
                }
            },


            checkStringContainUnicode: function(str){

                for (var i = 0, n = str.length; i < n; i++) {
                    if (str.charCodeAt( i ) > 255) { return true; }
                }
                return false;
        
            },


            urlSlug: function(_text){

              return _text.toString().toLowerCase()
                .replace(/\s+/g, '-')           // Replace spaces with -
                .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
                .replace(/\-\-+/g, '-')         // Replace multiple - with single -
                .replace(/^-+/, '')             // Trim - from start of text
                .replace(/-+$/, '');            // Trim - from end of text

            },

            urlSlugFixCafe: function(_text){

              return _text.toString().toLowerCase()
                .replace(/\s+/g, '-')           // Replace spaces with -
                // .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
                .replace(/\-\-+/g, '-')         // Replace multiple - with single -
                .replace(/^-+/, '')             // Trim - from start of text
                .replace(/-+$/, '');            // Trim - from end of text

            },


            slugUnicode: function(s, opt){

                /**
                 * Create a web friendly URL slug from a string.
                 *
                 * Requires XRegExp (http://xregexp.com) with unicode add-ons for UTF-8 support.
                 *
                 * Although supported, transliteration is discouraged because
                 *     1) most web browsers support UTF-8 characters in URLs
                 *     2) transliteration causes a loss of information
                 *
                 * @author Sean Murphy <sean@iamseanmurphy.com>
                 * @copyright Copyright 2012 Sean Murphy. All rights reserved.
                 * @license http://creativecommons.org/publicdomain/zero/1.0/
                 *
                 * @param string s
                 * @param object opt
                 * @return string
                 */

                    s = String(s);
                    opt = Object(opt);
                    
                    var defaults = {
                        'delimiter': '-',
                        'limit': undefined,
                        'lowercase': true,
                        'replacements': {},
                        'transliterate': (typeof(XRegExp) === 'undefined') ? true : false
                    };
                    
                    // Merge options
                    for (var k in defaults) {
                        if (!opt.hasOwnProperty(k)) {
                            opt[k] = defaults[k];
                        }
                    }
                    
                    var char_map = {
                        // Latin
                        'À': 'A', 'Á': 'A', 'Â': 'A', 'Ã': 'A', 'Ä': 'A', 'Å': 'A', 'Æ': 'AE', 'Ç': 'C', 
                        'È': 'E', 'É': 'E', 'Ê': 'E', 'Ë': 'E', 'Ì': 'I', 'Í': 'I', 'Î': 'I', 'Ï': 'I', 
                        'Ð': 'D', 'Ñ': 'N', 'Ò': 'O', 'Ó': 'O', 'Ô': 'O', 'Õ': 'O', 'Ö': 'O', 'Ő': 'O', 
                        'Ø': 'O', 'Ù': 'U', 'Ú': 'U', 'Û': 'U', 'Ü': 'U', 'Ű': 'U', 'Ý': 'Y', 'Þ': 'TH', 
                        'ß': 'ss', 
                        'à': 'a', 'á': 'a', 'â': 'a', 'ã': 'a', 'ä': 'a', 'å': 'a', 'æ': 'ae', 'ç': 'c', 
                        'è': 'e', 'é': 'e', 'ê': 'e', 'ë': 'e', 'ì': 'i', 'í': 'i', 'î': 'i', 'ï': 'i', 
                        'ð': 'd', 'ñ': 'n', 'ò': 'o', 'ó': 'o', 'ô': 'o', 'õ': 'o', 'ö': 'o', 'ő': 'o', 
                        'ø': 'o', 'ù': 'u', 'ú': 'u', 'û': 'u', 'ü': 'u', 'ű': 'u', 'ý': 'y', 'þ': 'th', 
                        'ÿ': 'y',

                        // Latin symbols
                        '©': '(c)',

                        // Greek
                        'Α': 'A', 'Β': 'B', 'Γ': 'G', 'Δ': 'D', 'Ε': 'E', 'Ζ': 'Z', 'Η': 'H', 'Θ': '8',
                        'Ι': 'I', 'Κ': 'K', 'Λ': 'L', 'Μ': 'M', 'Ν': 'N', 'Ξ': '3', 'Ο': 'O', 'Π': 'P',
                        'Ρ': 'R', 'Σ': 'S', 'Τ': 'T', 'Υ': 'Y', 'Φ': 'F', 'Χ': 'X', 'Ψ': 'PS', 'Ω': 'W',
                        'Ά': 'A', 'Έ': 'E', 'Ί': 'I', 'Ό': 'O', 'Ύ': 'Y', 'Ή': 'H', 'Ώ': 'W', 'Ϊ': 'I',
                        'Ϋ': 'Y',
                        'α': 'a', 'β': 'b', 'γ': 'g', 'δ': 'd', 'ε': 'e', 'ζ': 'z', 'η': 'h', 'θ': '8',
                        'ι': 'i', 'κ': 'k', 'λ': 'l', 'μ': 'm', 'ν': 'n', 'ξ': '3', 'ο': 'o', 'π': 'p',
                        'ρ': 'r', 'σ': 's', 'τ': 't', 'υ': 'y', 'φ': 'f', 'χ': 'x', 'ψ': 'ps', 'ω': 'w',
                        'ά': 'a', 'έ': 'e', 'ί': 'i', 'ό': 'o', 'ύ': 'y', 'ή': 'h', 'ώ': 'w', 'ς': 's',
                        'ϊ': 'i', 'ΰ': 'y', 'ϋ': 'y', 'ΐ': 'i',

                        // Turkish
                        'Ş': 'S', 'İ': 'I', 'Ç': 'C', 'Ü': 'U', 'Ö': 'O', 'Ğ': 'G',
                        'ş': 's', 'ı': 'i', 'ç': 'c', 'ü': 'u', 'ö': 'o', 'ğ': 'g', 

                        // Russian
                        'А': 'A', 'Б': 'B', 'В': 'V', 'Г': 'G', 'Д': 'D', 'Е': 'E', 'Ё': 'Yo', 'Ж': 'Zh',
                        'З': 'Z', 'И': 'I', 'Й': 'J', 'К': 'K', 'Л': 'L', 'М': 'M', 'Н': 'N', 'О': 'O',
                        'П': 'P', 'Р': 'R', 'С': 'S', 'Т': 'T', 'У': 'U', 'Ф': 'F', 'Х': 'H', 'Ц': 'C',
                        'Ч': 'Ch', 'Ш': 'Sh', 'Щ': 'Sh', 'Ъ': '', 'Ы': 'Y', 'Ь': '', 'Э': 'E', 'Ю': 'Yu',
                        'Я': 'Ya',
                        'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'yo', 'ж': 'zh',
                        'з': 'z', 'и': 'i', 'й': 'j', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o',
                        'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'у': 'u', 'ф': 'f', 'х': 'h', 'ц': 'c',
                        'ч': 'ch', 'ш': 'sh', 'щ': 'sh', 'ъ': '', 'ы': 'y', 'ь': '', 'э': 'e', 'ю': 'yu',
                        'я': 'ya',

                        // Ukrainian
                        'Є': 'Ye', 'І': 'I', 'Ї': 'Yi', 'Ґ': 'G',
                        'є': 'ye', 'і': 'i', 'ї': 'yi', 'ґ': 'g',

                        // Czech
                        'Č': 'C', 'Ď': 'D', 'Ě': 'E', 'Ň': 'N', 'Ř': 'R', 'Š': 'S', 'Ť': 'T', 'Ů': 'U', 
                        'Ž': 'Z', 
                        'č': 'c', 'ď': 'd', 'ě': 'e', 'ň': 'n', 'ř': 'r', 'š': 's', 'ť': 't', 'ů': 'u',
                        'ž': 'z', 

                        // Polish
                        'Ą': 'A', 'Ć': 'C', 'Ę': 'e', 'Ł': 'L', 'Ń': 'N', 'Ó': 'o', 'Ś': 'S', 'Ź': 'Z', 
                        'Ż': 'Z', 
                        'ą': 'a', 'ć': 'c', 'ę': 'e', 'ł': 'l', 'ń': 'n', 'ó': 'o', 'ś': 's', 'ź': 'z',
                        'ż': 'z',

                        // Latvian
                        'Ā': 'A', 'Č': 'C', 'Ē': 'E', 'Ģ': 'G', 'Ī': 'i', 'Ķ': 'k', 'Ļ': 'L', 'Ņ': 'N', 
                        'Š': 'S', 'Ū': 'u', 'Ž': 'Z', 
                        'ā': 'a', 'č': 'c', 'ē': 'e', 'ģ': 'g', 'ī': 'i', 'ķ': 'k', 'ļ': 'l', 'ņ': 'n',
                        'š': 's', 'ū': 'u', 'ž': 'z'
                    };
                    
                    // Make custom replacements
                    for (var k in opt.replacements) {
                        s = s.replace(RegExp(k, 'g'), opt.replacements[k]);
                    }
                    
                    // Transliterate characters to ASCII
                    if (opt.transliterate) {
                        for (var k in char_map) {
                            s = s.replace(RegExp(k, 'g'), char_map[k]);
                        }
                    }
                    
                    // Replace non-alphanumeric characters with our delimiter
                    var alnum = (typeof(XRegExp) === 'undefined') ? RegExp('[^a-z0-9]+', 'ig') : XRegExp('[^\\p{L}\\p{N}]+', 'ig');
                    s = s.replace(alnum, opt.delimiter);
                    
                    // Remove duplicate delimiters
                    s = s.replace(RegExp('[' + opt.delimiter + ']{2,}', 'g'), opt.delimiter);
                    
                    // Truncate slug to max. characters
                    s = s.substring(0, opt.limit);
                    
                    // Remove delimiter from ends
                    s = s.replace(RegExp('(^' + opt.delimiter + '|' + opt.delimiter + '$)', 'g'), '');
                    
                    return opt.lowercase ? s.toLowerCase() : s;

            },


            // get language translate from locale json string in category obj
            getRestDetail: function(obj){
                // console.log(obj);
                if(!obj)
                    return '';

                
                var _slug = obj.slug;
                if(!_slug){
                    // console.log(obj.directory_name);
                    _slug = public_method.slugUnicode(obj.name)
                }
                else{
                    _slug = obj.slug;
                }
                // console.log(_slug);

                return (obj._id || obj.id )+'-'+_slug;
            },   

            // get language translate from locale json string in category obj
            getReadParam: function(obj){
                
                // console.log(obj.slug);
                // var _slug = obj.slug;
                if(obj.is_read === true)
                    return '';
                else
                    return '?r='+obj._id;
            },   

            dateToTimesteam: function(date){

                // var _newMoment = moment(date);
                // var _newDate = moment(_newMoment._i).days() + '/' + moment(_newMoment._i).months() + '/' + moment(_newMoment._i).year()

                // console.log(_newDate);
                return moment(date).format('MMM DD, YYYY');
                // return moment(date).unix()*1000;
            },

            removeHttpHttps: function(url){
                if(!url)
                    return '';
                var str = url.replace('http://', '');
                str = str.replace('https://', '');
                return str;
            }

        };

        return public_method;
    }]);

}());