document.getElementById('acceptButton').addEventListener('click', function() {
    document.getElementById('cookieCard').style.display = 'none';
});

document.getElementById('declineButton').addEventListener('click', function() {
    document.getElementById('cookieCard').style.display = 'none';
});

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('cookieCard').style.display = 'flex';
});