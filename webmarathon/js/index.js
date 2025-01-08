// Chọn tất cả các phần tử có lớp 'event-m'
const events = document.querySelectorAll('.event-m');

events.forEach(event => {
    event.addEventListener('click', function (e) {
        // Kiểm tra xem phần tử được nhấp có phải là liên kết bên trong không
        if (!e.target.closest('.b-register')) {
            const url = this.getAttribute('data-url');
            if (url) {
                window.location.href = url;
            }
        }
    });
});
// Tính toán thời gian còn lại
const timeRemainingElements = document.querySelectorAll('.time-remaining');

timeRemainingElements.forEach(element => {
    const eventDate = new Date(element.getAttribute('data-date'));
    const updateTimeRemaining = () => {
        const now = new Date();
        const timeRemaining = eventDate - now;

        if (timeRemaining > 0) {
            const days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
            const hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

            element.textContent = `${days}d ${hours}h ${minutes}m ${seconds}s`;
        } else {
            element.textContent = 'Race has ended';
        }
    };

    updateTimeRemaining();
    setInterval(updateTimeRemaining, 1000);
});