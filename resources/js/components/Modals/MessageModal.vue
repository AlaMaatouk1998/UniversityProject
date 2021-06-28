<template>
	<modal :show.sync="modals.configNodeModal">
		<template slot="header">
			<input v-model="newNodeConfig.title" class="modalTitle"  />
		</template>
		<div class="row">
			<div class="col-md-12">
				<p>Saisissez votre message à envoyer ici</p>
			</div>
			<div class="col-md-12">
				<textarea
					v-model="newNodeConfig.text"
					name=""
					
					cols="60"
					rows="5"
					placeholder="Saisissez votre message à envoyer ici"
				></textarea>
			</div>
			<div class="col-md-12">
				<template>
					<table class="table bordered">
						<thead>
							<tr>
								<th scope="col" class="text-left">Option</th>
								<th scope="col" class="text-left">Value</th>
								<th scope="col" class="text-center">Value</th>
								<th scope="col" class="text-center"></th>
							</tr>
						</thead>
						<draggable v-model="optionsData" tag="tbody">
							<tr v-for="row in optionsData" :key="row.key" v-show="row.key != -1">
								<td><input v-model="row.title" class="modalTitle" /></td>
								<td><input v-model="row.value" class="modalTitle" /></td>
								<td>
									<base-button
										class="addBtn"
										type="danger"
										size="sm"
										icon
										@click="removeOption(row.key)"
									>
										<i class="tim-icons icon-simple-remove"></i>
									</base-button>
								</td>
								<td>
									<base-button class="addBtn" type="success" size="sm" icon>
										<i class="tim-icons icon-tap-02"></i>
									</base-button>
								</td>
							</tr>
						</draggable>
					</table>

					<base-button
						class="addBtn"
						type="success"
						size="sm"
						icon
						@click="addNewOption()"
					>
						<i class="tim-icons icon-simple-add"></i>
					</base-button>
				</template>
			</div>
		</div>
		<template slot="footer">
			<base-button type="secondary" @click="modals.configNodeModal = false"
				>Annuler</base-button
			>
			<base-button type="primary" @click="updateMessage()"
				>Enregistrer</base-button
			>
		</template>
	</modal>
</template>
<script>
import draggable from "vuedraggable";
import { Card, Modal } from "../../components/index";

export default {
	components: {
		Card,
		Modal,
		draggable
	},
	props: [
		"optionsData",
		"newNodeConfig",
		"modals",
		"addNewOption",
		"updateMessage",
		"removeOption"
	],
	computed: {}
};
</script>
