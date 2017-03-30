var Heart = function(selector){
    this.el = document.querySelector(selector);
    var _this = this;
    this.init = function(){
        Snap.load("../assets/img/reactions/love.svg", function(data){
            Snap(selector).append(data);
            _this.el.addEventListener("click", function(){
                if(_this.el.parentElement.classList.contains("active"))
                    _this.unFavAnim();
                else
                    _this.favAnim();
            });
        });
    }
    var _this = this;
    this.favAnim = function(){
        var s = Snap(selector);
        var heart = s.select("#heart");
        var circle = s.select("#circle");
        var explosion1 = s.select("#explosion-1");
        var explosion1Backup = s.select("#explosion-1").attr("d");
        var explosion2 = s.select("#explosion-2");
        circle.animate({transform:"scale(0.9) translate(3, 3)"}, 200, mina.ease);
        heart.animate({transform:"scale(0.5) translate(40, 40)"}, 200, mina.ease, function(){
            circle.animate({transform:"scale(1.2) translate(-8, -8)"}, 300);
            heart.animate({transform:"scale(1.8) translate(-19, -19)"}, 200, mina.easein, function(){
                heart.animate({transform:"scale(1)"}, 300, mina.ease);
                circle.animate({transform:"scale(1)"}, 500, mina.ease); _this.el.parentElement.classList.add("active");
            });
            explosion1.animate({d: explosion2.attr("d"), opacity: "0"}, 700, mina.easein, function(){//reinit
                explosion1.attr({d: explosion1Backup, opacity: "1"});
            });
        });
    }
    this.unFavAnim = function(){
        var s = Snap(selector);
        var heart = s.select("#heart");
        var heartBackup = s.select("#heart").attr("d");
        var heart2 = s.select("#heart-broken");
        heart.animate({d: heart2.attr("d")}, 200, mina.ease, function(){
            setTimeout(function(){
                heart.animate({d: heartBackup}, 200, mina.ease, function(){
                    _this.el.parentElement.classList.remove("active");
                });
            }, 500);
        });
    }
    this.init();
}
var hearts = document.querySelectorAll(".heart");
for(var i=0; i<hearts.length; i++){
    hearts[i].classList.add("heart-"+i)
    hearts[i] = new Heart(".heart-"+i);
}



var Thumb = function(selector, upDown){
    this.el = document.querySelector(selector);
    var _this = this;
    this.init = function(){
        Snap.load("../assets/img/reactions/thumb"+upDown+".svg", function(data){
            Snap(selector).append(data);

            // init elements :
            var s = Snap(selector);
            if(_this.el.parentElement.classList.contains("active")) {
                s.select("#circle-color").attr({transform: "scale(1)"});
                var thumbBackup = s.select("#thumb-hidden").attr("d");
                s.select("#thumb-hidden").attr({d: s.select("#thumb").attr("d")});
                s.select("#thumb").attr({d: thumbBackup, transform: "translateX(-50%)"});
            }
            else {
                s.select("#circle-color").attr({transform: "translate(40, 40) scale(0)"});
                s.select("#thumb-hidden").attr({transform: "translateX(-50%)"});
            }

            _this.el.addEventListener("click", function(){
                // anims:
                if(_this.el.parentElement.classList.contains("active"))
                    _this.unThumbAnim();
                else
                    _this.thumbAnim();
            });
        });
    }
    var _this = this;
    this.thumbAnim = function(){
        var s = Snap(selector);
        var thumb = s.select("#thumb");
        var thumbHidden = s.select("#thumb-hidden");
        var thumbBackup = thumbHidden.attr("d");
        var circleGrey = s.select("#circle-grey");
        var circleBlue = s.select("#circle-color");
        var explosion1 = s.select("#explosion-1");
        var explosion2 = s.select("#explosion-2");
        var explosion1Backup = s.select("#explosion-1").attr("d");
        circleGrey.animate({transform:"scale(0.9) translate(3, 3)"}, 200, mina.ease);
        thumb.animate({transform:"translate(40, 40) scale(0)"}, 200, mina.ease, function(){
            thumbHidden.animate({transform:"translateX(-20%)"}, 400, mina.ease, function(){
                var rot = upDown=="down" ? 3 : -3;
                var tslt = upDown=="down" ? -5 : -15;
                thumbHidden.animate({d: thumb.attr("d"), transform:"rotate("+rot+") translate("+tslt+", "+tslt+") scale(1.2)"}, 400, mina.easein, function(){
                    thumbHidden.animate({transform:"translate(0) scale(1)"}, 200, mina.easein, function(){
                        thumb.attr({d: thumbBackup});//reinit
                    });
                });
            });
            circleBlue.animate({transform: "scale(1.2) translate(-8, -8)"}, 200, function(){
                circleBlue.animate({transform:"scale(1)"}, 300, mina.ease);
                _this.el.parentElement.classList.add("active");
            });
            explosion1.animate({d: explosion2.attr("d"), opacity: "0"}, 1000, mina.easein, function(){
                explosion1.attr({d: explosion1Backup, opacity: "1"});//reinit
            });
        });
    }
    this.unThumbAnim = function(){
        var s = Snap(selector);
        var thumb = s.select("#thumb");
        var thumbHidden = s.select("#thumb-hidden");
        var thumbBackup = thumbHidden.attr("d");
        var circleBlue = s.select("#circle-color");
        var circleGrey = s.select("#circle-grey");
        circleBlue.animate({transform: "translate(40, 40) scale(0)"}, 200, mina.ease);
        thumbHidden.animate({d: thumb.attr("d")}, 700, mina.ease, function(){
            thumbHidden.animate({d: thumb.attr("d"), transform: "translate(-50)"}, 200, mina.ease);
            thumb.attr({d: thumbBackup, transform: "translate(50)"});
            thumb.animate({transform: "scale(1)", opacity: 1}, 200, mina.ease);
        });
        _this.el.parentElement.classList.remove("active");
    }
    this.init();
}
var thumbs = document.querySelectorAll("[class^='thumb']");
for(var i=0; i<thumbs.length; i++){
    thumbs[i].classList.add("thumb-"+i);
    thumbs[i] = new Thumb(
        ".thumb-"+i,
        thumbs[i].classList.contains("thumb-up") ? "up" : "down"
    );
}
