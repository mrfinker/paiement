</div>
<!-- wrap @e -->
</div>
<!-- app-root @e -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<?=URL?>public/assets/js/bundle.js?ver=3.2.0"></script>
<script src="<?=URL?>public/assets/js/scripts.js?ver=3.2.0"></script>
<script src="<?=URL?>public/assets/js/charts/gd-default.js?ver=3.2.0"></script>
<script
src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<script
src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
new Chart(document.getElementById("pie-chart"), {
type: 'pie',
data: {
    labels: [
        "Ressources Humaines", "IT", "Finance", "Marketing", "Production"
    ],
    datasets: [
        {
            label: "Nombre d'Employés",
            backgroundColor: [
                "#3e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9", "#c45850"
            ],
            data: [20, 30, 15, 25, 10]
        }
    ]
},
options: {
    legend: {
        display: false
    }
}
});

new Chart(document.getElementById("doughnut-chart"), {
type: 'doughnut',
data: {
    labels: [
        "Développement", "Support", "Administration Réseau", "Sécurité"
    ],
    datasets: [
        {
            label: "Nombre d'Employés",
            backgroundColor: [
                "#3e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9"
            ],
            data: [10, 8, 7, 5]
        }
    ]
},
options: {
    legend: {
        display: false
    }
}
});

new Chart(document.getElementById("line-chart"), {
type: 'line',
data: {
    labels: [
        "Janvier",
        "Février",
        "Mars",
        "Avril",
        "Mai",
        "Juin",
        "Juillet",
        "Août",
        "Septembre",
        "Octobre",
        "Novembre",
        "Décembre"
    ],
    datasets: [
        {
            data: [
                500,
                800,
                200,
                1700,
                600,
                1800,
                750,
                1450,
                1000,
                1500,
                2000,
                2400
            ],
            label: "Dépenses",
            borderColor: "#3e95cd",
            fill: false
        }, {
            data: [
                200,
                450,
                300,
                500,
                1000,
                650,
                800,
                1500,
                1200,
                1600,
                1500,
                2000
            ],
            label: "Dépôts",
            borderColor: "#8e5ea2",
            fill: false
        }, {
            data: [
                100,
                200,
                150,
                300,
                400,
                500,
                450,
                300,
                400,
                500,
                600,
                700
            ],
            label: "Paiements",
            borderColor: "#3cba9f",
            fill: false
        }
    ]
},
options: {
    legend: {
        display: true // Vous pouvez le mettre à true si vous voulez afficher les labels.
    },
    maintainAspectRatio: false, // Cela assure que le graphique s'adapte à la taille du conteneur parent.
}
});

new Chart(document.getElementById("presence"), {
    type: 'line', // Changez le type à 'line'
    data: {
        labels: ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi"], // Labels pour chaque point de données
        datasets: [
            {
                label: "Présent",
                backgroundColor: "#3e95cd",
                borderColor: "#3e95cd",
                fill: false, // N'utilisez pas de couleur de remplissage sous la ligne
                data: [20, 25, 30, 35, 40] // Exemple de données pour les présents
            }, 
            {
                label: "Absent",
                backgroundColor: "#8e5ea2",
                borderColor: "#8e5ea2",
                fill: false, // N'utilisez pas de couleur de remplissage sous la ligne
                data: [10, 15, 20, 15, 10] // Exemple de données pour les absents
            }
        ]
    },
    options: {
        legend: {
        display: false // Vous pouvez le mettre à true si vous voulez afficher les labels.
    },
        scales: {
            xAxes: [{
                display: true // Cela montre les labels de l’axe X
            }],
            yAxes: [{
                ticks: {
                    beginAtZero: true // Le graphique commence à 0
                }
            }]
        }
    }
});


new Chart(document.getElementById("sexe"), {
    type: 'doughnut',
    data: {
        labels: ["Homme", "Femme"],
        datasets: [{
            backgroundColor: ["#3e95cd", "#9e95cd"],
            data: [<?=$maleCount; ?>, <?=$femaleCount; ?>] // Remplacez par le nombre réel d'hommes et de femmes
        }]
    },
    options: {
        legend: {
            display: false // Cela affiche les labels du dataset. Modifiez-le à `false` si vous ne voulez pas afficher les labels.
        },
        responsive: true, // Le graphique s'ajustera à la taille du conteneur
        maintainAspectRatio: true // Le graphique maintiendra son aspect ratio lors du redimensionnement.
    }
});




</script>

</body>

<?php
if (isset($this->js)) {
    foreach ($this->js as $js) {
        echo '<script src="' . URL . 'views/' . $js . '"></script>';
    }
}
?>
</html>