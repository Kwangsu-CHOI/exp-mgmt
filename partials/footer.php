<?php
$user_id = $_SESSION['user-id'];
$query = "SELECT SUM(transactions.amount) as amount, categories.title as title from transactions JOIN categories ON categories.id = transactions.category_id WHERE user_id = $user_id GROUP BY categories.title";
$result = mysqli_query($connection, $query);

if(mysqli_num_rows($result)>0) {

  foreach ($result as $data) {
    $title[] = $data['title'];
    $amt[] = intval($data['amount']);
  }
  
  if(!in_array('Expense', $title)) {
    array_push($title, 'Expense');
    array_push($amt, 0);
  } elseif(!in_array('Income', $title)) {
    array_push($title, 'Income');
    array_push($amt, 0);
  }

  $queryTwo = "SELECT year, month, sum(amount) AS amt, title FROM (SELECT transactions.amount AS amount, categories.title AS title, year(date_time) AS year, month(date_time) AS month FROM transactions JOIN categories ON categories.id = transactions.category_id WHERE user_id = $user_id) AS a WHERE title NOT IN ('Uncategorised') GROUP BY year, month, title";
  $resultTwo = mysqli_query($connection, $queryTwo);
  
  foreach ($resultTwo as $dataTwo) {
    $date[] = $dataTwo['month'] . " . " . $dataTwo['year'];
    $amount[] = intval($dataTwo['amt']);
    $titles[] = $dataTwo['title'];
    unset($titles['Uncategorised']);
  }
  if(!in_array('Expense', $titles)) {
    array_push($date, '9 . 2022');
    array_push($titles, 'Expense');
    array_push($amount, 0);
  } elseif(!in_array('Income', $titles)) {
    array_push($date, '9 . 2022');
    array_push($titles, 'Income');
    array_push($amount, 0);
  }
  $fin = array_map(function ($date, $titles, $amount) {
    return ['x' => $date, $titles => $amount];
  }, $date, $titles, $amount);


  // $j = count($fin);

  // for ($i = 0, $c = 1; $i < $j && $c < $j; $i += 2, $c += 2) {
  //   if($fin[$i]['x'] === $fin[$c]['x']) {
  //     $finn[] = array_merge($fin[$i], $fin[$c]);
  //   }
    
  //   array_push($finn, $fin[$j-1]);
  // }
  // $finnn = array_values($finn);
  
  $month = date('m');
  $query_three = "SELECT title, amount FROM transactions WHERE category_id = 2 AND month(date_time) = $month AND user_id = $user_id";
  $result_three = mysqli_query($connection, $query_three);
  if(mysqli_num_rows($result_three)>0) {
    foreach ($result_three as $dataThree) {
      $title_three[] = $dataThree['title'];
      $amt_three[] = intval($dataThree['amount']);
    }
  } else {
    $title_three[] = [];
    $amt_three[] = [];
  }
  // else {
  //   $month = date('m') - 1;
  //   $query_three = "SELECT title, amount FROM transactions WHERE category_id = 2 AND month(date_time) = $month AND user_id = $user_id";
  //   $result_three = mysqli_query($connection, $query_three);
  //   foreach ($result_three as $dataThree) {
  //   $title_three[] = $dataThree['title'];
  //   $amt_three[] = intval($dataThree['amount']);
  //   }
  // }
  // if(mysqli_num_rows($result_three)==0) {
  //   $title_three[] = [];
  //   $amt_three[] = [];
  // }
  

}

?>
<footer>
  <div class="footer__copyright">
    <!-- <small>Copyright &copy; 2022 Kwangsu CHOI</small><br> -->
  </div>
</footer>
<script type="text/javascript" src="<?= ROOT_URL ?>js/main.js"></script>
<script type="text/javascript" src="<?= ROOT_URL ?>js/color-theme.js"></script>
<script type="text/javascript" src="<?= ROOT_URL ?>js/tableSort.js"></script>
<script type="text/javascript" src="<?= ROOT_URL ?>js/tableEdit.js"></script>
<script type="text/javascript" src="<?= ROOT_URL ?>js/image-editor.js"></script>
<script type="text/javascript" src="<?= ROOT_URL ?>js/translator.js"></script>
<script type="text/javascript" src="<?= ROOT_URL ?>js/calculator.js"></script>
<script type="text/javascript" src="<?= ROOT_URL ?>js/chat.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.min.js"></script>

<script>
  //For Charts
  //First chart
  const dataOne = {
    labels: <?= json_encode($title) ?>,
    datasets: [{
      label: 'Totals',
      data: <?= json_encode($amt) ?>,
      backgroundColor: [
        'rgb(255, 99, 132)',
        'rgb(75, 192, 192)',
        'rgb(255, 205, 86)'
      ]
    }]
  };
  const configOne = {
    type: 'doughnut',
    data: dataOne,
    options: {
      responsive: true,
      plugins: {
      title: {
        display: true,
        text: "Income & Expense by Categories",
        padding: {bottom: 30},
        font: {
          size: 20
        }
      },
      legend: {
        display: true
      },
      tooltip: {
        enabled: true
      }
    }
    }
  };
  const chartOne = new Chart(
    document.getElementById('chartOne'),
    configOne
  );


  //Second Chart
  const labels = <?= json_encode(array_values(array_unique($date))) ?>;
  const dataTwo = <?= json_encode($fin) ?>;

  const datas = {
    labels: labels,
    datasets: [{
      label: 'Total Income',
      data: dataTwo,
      parsing: {
        yAxisKey: 'Income'
      },
      backgroundColor: [
        'rgba(54, 162, 235, 1)',
      ],
    }, {
      label: 'Total Expense',
      data: dataTwo,
      backgroundColor: [
        'rgba(255, 99, 132, 1)',
      ],
      parsing: {
        yAxisKey: 'Expense'
      }
    }]
  };

  const configTwo = {
    type: 'bar',
    data: datas,
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
          beginAtZero: true
        }
      },
      plugins: {
      title: {
        display: true,
        text: "Monthly Income & Expense",
        font: {
          size: 20
        }
      },
      legend: {
        display: true
      },
      tooltip: {
        enabled: true
      }
    }
    },
  };

  const chartTwo = new Chart(
    document.getElementById('chartTwo'),
    configTwo
  );

  //Third

const dataThree = {
  labels: <?= json_encode($title_three) ?>,
  datasets: [{
    label: 'Totals',
    data: <?= json_encode($amt_three) ?>,
    backgroundColor: [
      'rgb(128,128,128)'
    ]
  }]
};

const month = ["January","February","March","April","May","June","July","August","September","October","November","December"];
const d = new Date();
let mth = month[d.getMonth()];
const configThree = {
  type: 'bar',
  data: dataThree,
  options: {
    responsive: true,
    maintainAspectRatio: false,
    indexAxis: 'y',
    responsive: true,
    plugins: {
      title: {
        display: true,
        text: `Monthly Expense (${mth})`,
        font: {
          size: 20
        }
      },
      legend: {
        display: false
      },
      tooltip: {
        enabled: true
      }
    }
  }
};
const chartThree = new Chart(
  document.getElementById('chartThree'),
  configThree
);

</script>


</body>

</html>