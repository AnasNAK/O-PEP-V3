 
  const popupButton = document.getElementById('popupButton');
  const popupContainer = document.getElementById('popupContainer');

  popupButton.addEventListener('click', function () {
      popupContainer.classList.toggle('hidden');
  });