    function checkCapsLock(e) {
      var capsLockOn = e.getModifierState && e.getModifierState('CapsLock');
      if (capsLockOn) {
        document.getElementById('capsLockWarning').style.display = 'block';
      } else {
        document.getElementById('capsLockWarning').style.display = 'none';
      }
    }
