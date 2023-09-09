<template>
    <div class="wrapper">
      <!-- header -->
      <Header></Header>
      <!-- /.header -->
  
      <!-- sidebar -->
      <Sidebar></Sidebar>
      <!-- /.sidebar -->
  
      <!-- content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <!-- <ContentHeader></ContentHeader> -->
        <!-- /.Content Header (Page header) -->
  
        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <!-- ここに各ページのコンテンツが表示されます -->
            <slot></slot>
          </div>
        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
  
      <!-- Control sidebar content goes here -->
      <Controlbar></Controlbar>
      <!-- /.Control sidebar content goes here -->
      
      <!-- footer -->
      <Footer></Footer>
      <!-- /.footer -->
  
    </div>
  </template>
    
  <script>
  import Header from "./Header.vue";
  import Sidebar from "./Sidebar.vue";
  import Controlbar from "./Controlbar.vue";
  import Footer from "./Footer.vue";
 
  
  export default {
    components: {
      Header,
      Sidebar,
      Controlbar,
      Footer,
    },
  };
  </script>