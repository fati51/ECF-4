const salesData = [
    { date: '2024-01-01', genre: 'Action', status: 'LIVRÉ', sales: 10 },
    { date: '2024-01-02', genre: 'Action', status: 'LIVRÉ', sales: 15 },
    { date: '2024-01-03', genre: 'Action', status: 'LIVRÉ', sales: 7 },
    { date: '2024-01-01', genre: 'RPG', status: 'LIVRÉ', sales: 5 },
    { date: '2024-01-02', genre: 'RPG', status: 'LIVRÉ', sales: 8 },
    { date: '2024-01-03', genre: 'RPG', status: 'LIVRÉ', sales: 12 },
    // Ajoutez plus de données ici
];

// Filtrer les données pour ne garder que celles au statut "LIVRÉ"
const filteredSalesData = salesData.filter(sale => sale.status === 'LIVRÉ');

// Agréger les données par date et genre
const aggregatedSalesData = {};

filteredSalesData.forEach(sale => {
    const date = sale.date;
    const genre = sale.genre;
    const sales = sale.sales;
    
    if (!aggregatedSalesData[date]) {
        aggregatedSalesData[date] = {};
    }
    
    if (!aggregatedSalesData[date][genre]) {
        aggregatedSalesData[date][genre] = 0;
    }
    
    aggregatedSalesData[date][genre] += sales;
});

// Convertir les données agrégées en un format utilisable pour Chart.js
const labels = Object.keys(aggregatedSalesData).sort(); // Assurer que les dates sont triées
const genres = [...new Set(filteredSalesData.map(sale => sale.genre))];

const datasets = genres.map(genre => {
    return {
        label: genre,
        data: labels.map(date => aggregatedSalesData[date][genre] || 0),
        fill: false,
        borderColor: getRandomColor(),
        tension: 0.1
    };
});

// Fonction pour générer des couleurs aléatoires
function getRandomColor() {
    const letters = '0123456789ABCDEF';
    let color = '#';
    for (let i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

// Créer le graphique avec Chart.js
const ctx = document.getElementById('salesChart').getContext('2d');
const salesChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: datasets
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Ventes de Jeux Vidéo par Genre'
            }
        },
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'Date'
                }
            },
            y: {
                title: {
                    display: true,
                    text: 'Ventes'
                }
            }
        }
    }
});
