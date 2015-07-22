<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
       <ul class="nav navbar-nav navbar-right">
        <li>
          <?php  echo $this->HTML->link('Twitter',array(
                 'controller'=> 'tweets','action' => 'index'));
           ?>  
      </li>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

       <ul class="nav navbar-nav navbar-right">
        <li><a <?php  echo $this->HTML->link('Log out',array(
                 'controller'=> 'users','action' => 'logout'));
           ?></a></li>
      </ul>
     
      <ul class="nav navbar-nav navbar-right">
        <li><a <?php  echo $this->HTML->link('Find Friends',array(
                 'controller'=> 'users','action' => 'find'));
           ?></a></li>
      </ul>
       <ul class="nav navbar-nav navbar-right">
        <li>
          <?php  echo $this->HTML->link('Home',array(
                 'controller'=> 'tweets','action' => 'index'));
           ?>  
      </li>
      </ul>
     
      
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
