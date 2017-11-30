var initialDataLoaded = false;
var jackpotRef = new Firebase("YOUR-FIREBASE-LINK");

var icons = [
  {name:'fa-star', multiplier: 12},
  {name:'fa-heart', multiplier: 16},
  {name:'fa-bell', multiplier: 23},
  {name:'fa-bomb', multiplier: 28},
  {name:'fa-diamond', multiplier: 35},
  {name:'fa-money', multiplier: 50, jackpot: true},
]
var spinResult = [];
var balance = 0;
var controlsFrozen = false;

var spinReel = function(reelNumber){

  var reelElement = $('#reel-'+reelNumber).find("i");
  var x = 0;
  var spin = setInterval(function () {
    var randomIcon = icons[Math.floor(Math.random() * icons.length)];
    var classes = $(reelElement).attr('class').split(" ");
    $(reelElement).removeClass(classes[2]);
    $(reelElement).addClass(randomIcon.name);
    $(reelElement).addClass(randomIcon.multiplier);
    if (++x === 15) {
      window.clearInterval(spin);
      if(reelNumber === 3) checkResult();
    }
  }, 100);

}

var updateBalance = function(){

  $('#balance').html(balance+'.00');

}

var checkResult = function(){

  setTimeout(function(){
    var reel1 = $('#reel-1').find('i').attr('class').split(' ');
    var reel2 = $('#reel-2').find('i').attr('class').split(' ');
    var reel3 = $('#reel-3').find('i').attr('class').split(' ');

    if (reel1[2] === reel2[2] && reel2[2] === reel3[2]) {
      winner(reel1[2]);
    }

    controlsFrozen = false;
  }, 200);

}

var winner = function(result){

  icons.forEach(function(icon){

    if(result === icon.name){

      if(icon.jackpot){
        jackpot(icon.multiplier);
        winAnimation(true);
        return;
      }
      winAnimation();
      // The bet back plus the multiplier
      var x = 0;
      var winInterval = setInterval(function(){
        balance++;
        updateBalance();
        if(++x > icon.multiplier){
          window.clearInterval(winInterval);
        }
      }, 50);

    }

  });

}

var winAnimation = function(jackpot = false){

  var x = 0;
  var win = setInterval(function () {
    $('#reels').toggleClass('winner');
    if(jackpot){
      $('#spin').toggleClass('winner-button');
      $('#screen').toggleClass('winner');
    }
    if (++x === 6) {
      window.clearInterval(win);
    }
  }, 400);

}

var jackpot = function(multiplier){

  jackpotRef.once("value", function(data) {
    var jackpotWinnings = Math.floor(data.numChildren()/2) + multiplier;
    var x = 0;
    var jackpotInterval = setInterval(function(){
      if(++x > jackpotWinnings){
        window.clearInterval(jackpotInterval);
      }
      if(jackpotWinnings === 0 ) return;
      if(x % 2) $('#jackpot').toggleClass('winner');
      balance++;
      updateBalance();
    }, 50);
    jackpotRef.remove();
  });

}

var updateJackpot = function(jackpot){

  $('#jackpot-value').html('$'+Math.floor(jackpot/2)+'.00');

}

jackpotRef.once('value', function(snapshot) {

  initialDataLoaded = true;
  updateJackpot(snapshot.numChildren());

});

jackpotRef.on('child_added', function(snapshot) {

  if (!initialDataLoaded) return;
  jackpotRef.once("value", function(data) {
    updateJackpot(data.numChildren());
  });

});

jackpotRef.on('child_removed', function(snapshot) {

  if (!initialDataLoaded) return;
  jackpotRef.once("value", function(data) {
    updateJackpot(data.numChildren());
  });

});

$(document).ready(function(){

    updateBalance();

    $('#coin-slot-casing').on('click', function(){
      balance++;
      updateBalance();
    });

    $('#spin').on('click', function(){

      if(balance<=0) return;
      if(controlsFrozen) return;
      $('#jackpot').removeClass('winner');
      controlsFrozen = true;
      balance--;
      spinReel(1);
      spinReel(2);
      spinReel(3);
      jackpotRef.push({spin: true});
      updateBalance();

    });

});
