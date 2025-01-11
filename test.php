<?php

require_once __DIR__ . '/vendor/autoload.php';

use Config\Database;
use Classes\BaseModel;
use Classes\Article;
use Classes\User;
use Classes\Tag;
use Classes\Category;
use Auth\Auth;
use Handlers\ArticleHandler;

// Prepare data for the chart
// $categories = [];
// $counts = [];
// // Define colors for the chart
// $colors = [
//     'rgb(78, 115, 223)',    // primary
//     'rgb(28, 200, 138)',    // success
//     'rgb(54, 185, 204)',    // info
//     'rgb(246, 194, 62)',    // warning
//     'rgb(231, 74, 59)',     // danger
//     'rgb(133, 135, 150)',   // secondary
//     'rgb(90, 92, 105)',     // dark
//     'rgb(244, 246, 249)'    // light
// ];


// var_dump($topAuthors);
// var_dump($_SESSION['user']['role']);
// User::checkRole('admin');

// $categoryStats = $category->getCategoryStats();

// foreach ($categoryStats as $stat) {
//     $categories[] = $stat['name'];
//     $counts[] = $stat['totalArticles'];
// }

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>DevBlog - Dashboard</title>

    <!-- Custom fonts for this template-->
    <!-- <link href="./public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css"> -->
    <!-- <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet"> -->

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->

    <!-- Custom styles for this template-->
    <!-- <link href="./public/assets/css/sb-admin-2.css" rel="stylesheet"> -->

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include './views/components/sidebar.php'; ?>


        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include './views/components/topbar.php'; ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                    <body id="page-top">
                        <!-- Page Wrapper -->
                        <div id="wrapper">
                            <?php include './views/components/sidebar.php'; ?>
                            <!-- Content Wrapper -->
                            <div id="content-wrapper" class="d-flex flex-column">
                                <!-- Main Content -->
                                <div id="content">
                                    <?php include './views/components/topbar.php'; ?>
                                    <!-- Begin Page Content -->
                                    <div class="container-fluid">
                                        <!-- Page Heading -->
                                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                                            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                                        </div>

                                        <!-- Chart Container -->
                                        <div class="chart-container">
                                            <canvas id="categoryPieChart"></canvas>
                                        </div>
                                    </div>
                                    <!-- End of Main Content -->
                                    <?php include 'components/footer.php'; ?>
                                </div>
                                <!-- End of Content Wrapper -->
                            </div>
                            <!-- End of Page Wrapper -->
                        </div>

                        <!-- Initialize the pie chart -->
                        <script>
                            // Static data for the chart
                            const categories = ['Technology', 'Science', 'Health', 'Travel', 'Food'];
                            const counts = [30, 20, 15, 10, 25]; // Corresponding counts for each category
                            const colors = [
                                'rgb(78, 115, 223)', // primary
                                'rgb(28, 200, 138)', // success
                                'rgb(54, 185, 204)', // info
                                'rgb(246, 194, 62)', // warning
                                'rgb(231, 74, 59)' // danger
                            ];

                            // Get the canvas element
                            const ctx = document.getElementById('categoryPieChart').getContext('2d');

                            // Create the pie chart
                            const categoryPieChart = new Chart(ctx, {
                                type: 'pie', // Use 'pie' for a pie chart
                                data: {
                                    labels: categories, // Category names
                                    datasets: [{
                                        data: counts, // Counts for each category
                                        backgroundColor: colors, // Colors for each category
                                        hoverBackgroundColor: colors, // Colors on hover
                                        hoverBorderColor: "rgba(234, 236, 244, 1)", // Border color on hover
                                    }],
                                },
                                options: {
                                    responsive: true, // Make the chart responsive
                                    maintainAspectRatio: false, // Allow custom sizing
                                    plugins: {
                                        legend: {
                                            position: 'bottom', // Position the legend at the bottom
                                        },
                                        tooltip: {
                                            enabled: true, // Enable tooltips
                                            callbacks: {
                                                label: function(context) {
                                                    const label = context.label || '';
                                                    const value = context.raw || 0;
                                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                                    const percentage = ((value / total) * 100).toFixed(2) + '%';
                                                    return `${label}: ${value} (${percentage})`;
                                                }
                                            }
                                        }
                                    }
                                },
                            });
                        </script>
                    </body>

</html>