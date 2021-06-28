<template>
    <div class="content">
        <div class="login" ><i class="tim-icons  icon-refresh-02 rotating"></i></div>
    </div>
</template>

<script>
export default {
    created(){
        this.$store.dispatch('destroyToken')
         .then(response => {
               this.$router.push('/login');
         })
         .catch(()=>{
            this.$router.push('/login');
         })
    }
}
</script>
<style>
@media screen and (max-width: 576px){
.footer .nav {
    float: left;
    padding-left: 15px;
	margin-top: -100px;
	z-index: 155;
	text-align: left;

}
.footer .copyright{
	padding-left: 15px !important;
	text-align: left;
}
.lastCard{
	margin-bottom: 80px;
}
}

@media screen and (max-width: 768px){
.addBtnClass{
   float: left !important
}

}
.addBtnClass{
   float: right
}
.floating{
	transition: all 0.5s;
}
.floating:hover{
    -webkit-box-shadow: 0px 24px 45px -12px rgba(0,0,0,0.2);
    -moz-box-shadow: 0px 24px 45px -12px rgba(0,0,0,0.2);
    box-shadow: 0px 24px 45px -12px rgba(0,0,0,0.2);
    transform: translateY(-8px);
}


::-webkit-scrollbar {
  width: 6px;
}

::-webkit-scrollbar-track {
  border-radius: 0;
}

::-webkit-scrollbar-thumb {
  margin: 2px;
  border-radius: 10px;
  background: rgba(0, 0, 0, 0.2);
}

.modal.show .modal-dialog {
	-webkit-transform: translate(0, 0%);
	transform: translate(0, 0%);
}
.font-icon-detail {
	cursor: pointer;
}
/* .modal-content {
	
} */
.modalTitle {
	border: none;
}

.addBtn {
	width: 100% !important;
}

.modal {
	overflow-y: auto;
}
.textcomplete-item:hover{
	background: #c7ecee;
}
.textcomplete-dropdown{
	overflow-y: scroll;
	max-height: 300px;
}
.textcomplete-dropdown li{
    padding: 10px;
}
.font-icon-list{
	min-width: 220px;
}
.font-icon-detail{
	min-height: 200px;
}
.input-group-append, .input-group-prepend .input-group-text, .input-group-prepend .input-group-text {
    border-color: rgba(29, 37, 59, 0.5)!important;
}
.inputIcons{
    color:black !important;
}

.selected{
	    border: grey 1.5px solid !important;
}


.bm-menu{
	position: absolute;
	background-color: white;
	border-right: 1px solid #9a909054;
	overflow-y: scroll;
}
.bm-burger-button{
	display: none;
}
.bm-item-list  span{
	padding: .2em;
	font-weight: 300;
	    font-size: 15px;
	color: black
}
.bm-item-list >h4{
	margin-left: 10px;
}
.bm-item-list>* {
	padding: .2em;
}
.bm-item-list> a>i {
	margin-top: 3px;
}


hr{
	width: 200px;
	margin-right:50px;
}
.form-control {
	    border-radius: 0.1285rem;
}
@-webkit-keyframes rotating /* Safari and Chrome */ {
  from {
    -webkit-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  to {
    -webkit-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes rotating {
  from {
    -ms-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -webkit-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  to {
    -ms-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -webkit-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
.rotating {
  -webkit-animation: rotating 2s linear infinite;
  -moz-animation: rotating 2s linear infinite;
  -ms-animation: rotating 2s linear infinite;
  -o-animation: rotating 2s linear infinite;
  animation: rotating 2s linear infinite;
}

.login{
    font-size: 22px;  
    color: #2ed573;
}
</style>