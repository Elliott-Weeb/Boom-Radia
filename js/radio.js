/*!
 *  Howler.js Radio Demo
 *  howlerjs.com
 *
 *  (c) 2013-2020, James Simpson of GoldFire Studios
 *  goldfirestudios.com
 *
 *  MIT License
 */

// Cache references to DOM elements.
var player = document.getElementById('radio-player');
var elms = ['station0', 'title0', 'live0', 'wave-bars0', 'station1', 'title1', 'live1', 'playing1', 'station2', 'title2', 'live2', 'playing2', 'station3', 'title3', 'live3', 'playing3', 'station4', 'title4', 'live4', 'playing4'];
elms.forEach(function(elm) {
  window[elm] = document.getElementById(elm);

});
var Radio = function(stations) {
  var self = this;

  self.stations = stations;
  self.index = 0;

  // Setup the display for each station.
  for (var i=0; i<self.stations.length; i++) {
    window['title' + i].innerHTML = '<b>' + self.stations[i].freq + '</b> ' + self.stations[i].title;
    //Changed title formatting so I can replace items through Jquery -- Silvena Lam
    // window['title' + i].innerHTML = '<b>' + self.stations[i].freq + self.stations[i].title + '</b><p id="song-title"><span>Song Title</span></p>';
    window['station' + i].addEventListener('click', function(index) {
      var isNotPlaying = (self.stations[index].howl && !self.stations[index].howl.playing());

      // Stop other sounds or the current one.
      radio.stop();

      // If the station isn't already playing or it doesn't exist, play it.
      if (isNotPlaying || !self.stations[index].howl) {
        radio.play(index);
      }
    }.bind(self, i));
  }
};

// PLAY/PAUSE BUTTON CODE
$('.button-play').click(function() {
  icon = $(this).find('i');

  if (icon.hasClass('fa-play')) {
    icon.removeClass('fa-play');
    icon.addClass('fa-pause');
    waveAfterWave();
  } else {
    icon.removeClass('fa-pause');
    icon.addClass('fa-play');
    $('.wave').addClass('no-animation');
  }
});

// WAVE ON/OFF CODE
function waveAfterWave() {
  $('.wave').each(function(){
    height = $(this).height();
    $(this).css('height', height);
  });
  $('.wave').removeClass('no-animation');
};

// RADIO PROGRAM CODE
Radio.prototype = {

  play: function(index) {
    var self = this;
    var sound;
    index = typeof index === 'number' ? index : self.index;
    var data = self.stations[index];
	var controlBtn = document.getElementById('playBtn-pauseBtn');
    // If we already loaded this track, use the current one.
    // Otherwise, setup and load a new Howl.
    if (data.howl) {
      sound = data.howl;
    } else {
      sound = data.howl = new Howl({
        src: data.src,
        html5: true, // A live stream can only be played through HTML5 Audio.
	  format: ['mp3', 'aac']
      });
    }
    // Begin playing the sound.
    sound.play();
    // Toggle the display.
    self.toggleStationDisplay(index, true);
    // Keep track of the index we are currently playing.
    self.index = index;
  },
  // Stopping
  stop: function() {
    var self = this;
    // Get the Howl we want to manipulate.
    var sound = self.stations[self.index].howl;
    // Toggle the display.
    self.toggleStationDisplay(self.index, false);
    // Stop the sound.
    if (sound) {
      sound.unload();
    }
  },
  toggleStationDisplay: function(index, state) {
    var self = this;
  }
};


// DEFINE BOOM RADIO
var radio = new Radio([
  {
    freq: 'Now Listening:<br>',
    title: "Boom Radio",
    src: 'http://87.98.130.255:8132/stream?icy=https',
    howl: null
  }
]);
