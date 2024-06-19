// script.js

document.addEventListener('DOMContentLoaded', function() {
    const promoContainer = document.getElementById('promo-container');

    // Exemple de données de jeu en promotion
    const games = [
        { title: 'Basket ball', oldPrice: '59.99€', newPrice: '39.99€', description: 'un peu de sport.', image: './images/basket.jpg' },
        { title: 'Aventure', oldPrice: '49.99€', newPrice: '29.99€', description: 'Une aventure épique.', image: './images/jeux aventure.png' },
        { title: 'Star Wars', oldPrice: '69.99€', newPrice: '49.99€', description: 'Une expérience immersive.', image: './images/star wars.jpg' },
    ];

    games.forEach(game => {
        const card = document.createElement('div');
        card.className = 'card col-md-3';

        card.innerHTML = `
            <img src="${game.image}" alt="${game.title}">
            <div class="card-title">${game.title}</div>
            <div class="card-price">Prix: ${game.newPrice}</div>
            <div class="card-old-price">Ancien prix: ${game.oldPrice}</div>
            <div class="card-description">${game.description}</div>
        `;

        promoContainer.appendChild(card);
    });
});



