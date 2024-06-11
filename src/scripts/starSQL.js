document.addEventListener('DOMContentLoaded', (event) => {
    const stars = document.querySelectorAll('.star');
    let selectedRating = 0;

    stars.forEach((star, index) => {
        star.addEventListener('mouseover', () => {
            resetStars();
            for (let i = 0; i <= index; i++) {
                stars[i].classList.add('text-yellow-300');
                stars[i].classList.remove('text-gray-300', 'dark:text-gray-500');
            }
        });

        star.addEventListener('mouseout', () => {
            if (selectedRating === 0) {
                resetStars();
            } else {
                resetStars();
                for (let i = 0; i < selectedRating; i++) {
                    stars[i].classList.add('text-yellow-300');
                    stars[i].classList.remove('text-gray-300', 'dark:text-gray-500');
                }
            }
        });

        star.addEventListener('click', () => {
            selectedRating = index + 1;
        });
    });

    function resetStars() {
        stars.forEach(star => {
            star.classList.add('text-gray-300', 'dark:text-gray-500');
            star.classList.remove('text-yellow-300');
        });
    }

    document.querySelectorAll('.modal-open').forEach(button => {
        button.addEventListener('click', function() {
            const visitId = this.getAttribute('data-id');
            document.getElementById('close-button').setAttribute('data-id', visitId);
        });
    });

    document.getElementById('close-button').addEventListener('click', function(event) {
        const stars = document.querySelectorAll('.star');
        let rating = 0;
        stars.forEach((star, index) => {
            if (star.classList.contains('text-yellow-300')) {
                rating = index + 1;
            }
        });

        if (rating === 0) {
            alert('Por favor, selecione uma classificação de estrela antes de encerrar.');
            event.preventDefault(); // Prevent modal from closing
            return;
        }

        const feedback = document.getElementById('message').value;
        const visitId = this.getAttribute('data-id');

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'update_feedback.php', true);
        xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log('Feedback atualizado com sucesso');
                toggleModal();
                // Exibir mensagem de confirmação e recarregar a página
                alert('Atendimento encerrado');
                location.reload();
            } else if (xhr.readyState === 4) {
                console.error('Erro ao atualizar o feedback:', xhr.responseText);
            }
        };
        xhr.send(JSON.stringify({
            id: visitId,
            rating: rating,
            feedback: feedback,
            process: 1
        }));
    });
});
