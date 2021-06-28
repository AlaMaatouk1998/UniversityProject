<template>
	<modal :show.sync="modals.imageModal">
		<template slot="header">
			<input v-model="newImageConfig.title" class="modalTitle"/>
		</template>
        <template>

            <input type="file" accept="image/*" @change="onFileChange" />    
			 <transition name="fade">
                <div id="preview">
                    <img v-if="url" :src="url" />
                </div>
			 </transition>

			 
        </template>
		<template slot="footer">
			<base-button type="secondary" @click="modals.imageModal = false;"
				>Annuler</base-button
			>
			<base-button type="primary" @click="saveImage()"
				>Enregistrer</base-button
			>
		</template>
	</modal>
</template>
<script>
import draggable from "vuedraggable";
import { Modal, BaseInput } from "../../components/index";
var { Textcomplete, Textarea } = require('textcomplete');


export default {
	data(){
		return{
            url : null
		}
	},
	components: {
		Modal,
        draggable,
        BaseInput
	},
	props: [
		"modals",
		"saveImage",
		"newImageConfig",
	],
	computed: {},
	methods:{
		setUpAutoComplete(){
			var attributes = this.storedAttributes;
			console.log(attributes);
			var editor = new Textarea(document.getElementById('1'));
			var textcomplete = new Textcomplete(editor);
			textcomplete.register([{
			match: /(^|\s|{){([a-z0-9+\-\_]*)$/,
			search: function (term, callback) {
				callback(attributes.filter(attr => { 
					return attr.startsWith(term); 
					}));
			},
			replace: function (value) {
				return '$1{{' + value + '}} ';
			}
			}]);
        },
        onFileChange(e){
            const file = e.target.files[0];
            let imgId= new Date();
            this.newImageConfig.file = URL.createObjectURL(file);
            this.newImageConfig.text = file;
            // this.newImageConfig.id = new Date();
            this.url = URL.createObjectURL(file);
           
        }
	},
	mounted(){
			
	},
	watch: {
    storedAttributes: function () {
		this.setUpAutoComplete();
    }
  }
};
</script>
<style  scoped>
input{
    min-width :400px;
}
.textcomplete-item > a{
	padding: 6px !important;
	cursor: pointer!important;
}
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
#preview {
  display: flex;
  justify-content: center;
  align-items: center;
}

#preview img {
  max-width: 80px;
  max-height: 200px;
}
</style>
