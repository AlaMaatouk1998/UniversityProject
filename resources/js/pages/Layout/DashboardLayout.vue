<template>
  <div class="wrapper">
    <div class="wrapper" :class="{'nav-open': $sidebar.showSidebar}">

    <side-bar :background-color="backgroundColor" v-show="loggedIn && $route.name!='Home' && $route.name!='Recherche'"
    >    
      <!-- <mobile-menu slot="content"></mobile-menu> -->
   
      <sidebar-link to="/gerer/universites" >
        <i class="tim-icons icon-book-bookmark"></i>
        <template >
          <p>Universités</p>
        </template>
      </sidebar-link>
      <sidebar-link to="/gerer/etablissements" >
        <i class="tim-icons icon-bank"></i>
        <template >
          <p>Etablissements</p>
        </template>
      </sidebar-link>
      <sidebar-link to="/gerer/domaines" >
        <i class="tim-icons icon-puzzle-10"></i>
        <template >
          <p>Domaines</p>
        </template>
      </sidebar-link>
      <sidebar-link to="/gerer/diplomes" >
        <i class="tim-icons icon-paper"></i>
        <template >
          <p>Diplomes</p>
        </template>
      </sidebar-link>
      <sidebar-link to="/gerer/specialites" >
        <i class="tim-icons icon-single-copy-04"></i>
        <template >
          <p>Spécialités</p>
        </template>
      </sidebar-link>
      <sidebar-link to="/gerer/mentions" >
        <i class="tim-icons icon-shape-star"></i>
        <template >
          <p>Mentions</p>
        </template>
      </sidebar-link>
    </side-bar>
    <!-- <sidebar-share :background-color.sync="backgroundColor"></sidebar-share> -->

    <div class="main-panel" :data="backgroundColor">
      <top-navbar></top-navbar>

      <dashboard-content @click.native="toggleSidebar"></dashboard-content>

      <content-footer></content-footer>
    </div>
 </div>
  </div>
</template>
<style lang="scss"></style>
<script>

import TopNavbar from "./TopNavbar.vue";
import ContentFooter from "./ContentFooter.vue";
import DashboardContent from "./DashboardContent.vue";
import SidebarShare from "./SidebarSharePlugin.vue";
import MobileMenu from "./MobileMenu.vue";
import SideBar from "../../components/SidebarPlugin/SideBar.vue";
import SidebarLink from "../../components/SidebarPlugin/SidebarLink.vue";



export default{
  components: {
    TopNavbar,
    DashboardContent,
    ContentFooter,
    MobileMenu,
    SideBar,
    SidebarLink,
    SidebarShare
  },
  data() {
    return {
      backgroundColor: "green"
    };
  },
  computed: {
    isRTL() {
      return this.$rtl.isRTL;
    },
    user(){
       return this.$store.getters.user
    },
    loggedIn(){
      return this.$store.getters.loggedIn;
    }
  },
  methods: {
    toggleSidebar() {
      if (this.$sidebar.showSidebar) {
        this.$sidebar.displaySidebar(false);
      }
    }
  }
};
</script>
