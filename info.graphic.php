<?php
@session_start();
require_once 'db.php';
$id = $_SESSION['id'];
$SORGU = $DB->prepare("SELECT * FROM students WHERE addedunitid = :id");
$SORGU->bindParam(':id', $id);
$SORGU->execute();
$students = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($students);
die(); */
$totalStudents = count($students);
$SORGU = $DB->prepare("SELECT * FROM teachers WHERE addedunitid = :id");
$SORGU->bindParam(':id', $id);
$SORGU->execute();
$teachers = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($teachers);
die(); */
$totalTeachers = count($teachers);

$SORGU = $DB->prepare("SELECT * FROM informations WHERE addedunitid = :id");
$SORGU->bindParam(':id', $id);
$SORGU->execute();
$informations = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($informations);
die(); */
$schoolName = $informations[0]['schoolname'];
?>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<figure class="highcharts-figure">
    <div id="container"></div>
    <p class="highcharts-description">
    This chart gives us a visual representation of the number of teachers and students in the <?php echo $schoolName; ?>.
    </p>
</figure>
<script>
    var schoolName = '<?php echo $schoolName; ?>';
    var totalTeachers = <?php echo $totalTeachers; ?>;
    var totalStudents = <?php echo $totalStudents; ?>;
  Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Number of Teachers and Students in '+schoolName,
        align: 'left'
    },
    subtitle: {
        text:
            'School Name: <p><?php echo $schoolName ?> </p>',
        align: 'left'
    },
    xAxis: {
        categories: [schoolName],
        crosshair: true,
        accessibility: {
            description: 'Countries'
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Total number of persons'
        }
    },
    tooltip: {
        valueSuffix: ' (Person)'
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [
        {
            name: 'Total Teachers',
                data: [totalTeachers]
        },
        {
            name: 'Total Students',
            data: [totalStudents]
        }
    ]
});
</script>
