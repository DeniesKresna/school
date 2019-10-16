<template>
<div>
	<v-row>
		<v-col cols="12">
			<v-expansion-panels
		      v-model="show_search"
		    >
			    <v-expansion-panel>
			      <v-expansion-panel-header>Pencarian Utama Tabel Asset
				  </v-expansion-panel-header>
			      <v-expansion-panel-content>
			        <v-form>
						<v-container>
							<v-row>
								<v-col cols="12" md="3">
									<v-autocomplete v-model="picked_group" label="Group" @change="setCategoriesSearch(picked_group)" :items="autocompleteData"
								    ></v-autocomplete>
								</v-col>
								<v-col cols="12" md="3">
									<v-autocomplete v-model="picked_category" label="Tipe" :items="searchCategories"
								    ></v-autocomplete>
								</v-col><!--
								<v-col md="4">
									<v-text-field v-model="search" label="Filter" placeholder="ketik filteran"></v-text-field>
								</v-col>-->
								<v-col cols="12" md="2">
									<v-btn tile large outlined color="primary" @click="getAssets"><v-icon left>mdi-magnify</v-icon> Search</v-btn>
								</v-col>
							</v-row>
						</v-container>
					</v-form>
					<v-dialog v-model="importModal" persistent>
						      <template v-slot:activator="{ on }">
						        <v-btn color="success" dark class="mb-2 ml-3" v-on="on"><v-icon left>mdi-file-excel</v-icon>Import</v-btn>
						      </template>
						      <v-card>
						        <v-card-title class="headline">Import Asset dari Excel</v-card-title>
						        <v-card-text>
						        	<p>Sebelum anda import file excel, download dulu format excel <a href="format/assetimport.xlsx" target="blank">ini</a></p>
						        	<p>Jika sudah mengisi data excel tersebut, upload disini.</p>
						        	<p><v-file-input label="File Excel" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" v-model="assetFile"></v-file-input></p>
						        </v-card-text>
						        <v-card-actions>
						          <div class="flex-grow-1"></div>
						          <v-btn color="green darken-1" text @click="importAsset" v-if="assetFile">Import</v-btn>
						          <v-btn color="red darken-1" text @click="importModal = false">Keluar</v-btn>
						        </v-card-actions>
						      </v-card>
						    </v-dialog>
			      </v-expansion-panel-content>
			    </v-expansion-panel>
			</v-expansion-panels>
		</v-col>
	</v-row>
	<v-row v-if="has_search">
		<v-col md="12">
			<v-data-table
				:search="search"
			    :headers="headers"
			    :items="assets"
			    sort-by="asset_name"
			    class="elevation-1"
			  >
			    <template v-slot:top>
			      <v-toolbar flat color="white">
			        <v-toolbar-title>Tabel Asset </v-toolbar-title>
			        <v-divider
			          class="mx-4"
			          inset
			          vertical
			        ></v-divider><span class="caption red--text">ditemukan {{assets.length}} data.</span>
			        <div class="flex-grow-1"></div>
			        <v-dialog v-model="editModal" max-width="800px">
			          <template v-slot:activator="{ on }">
			            <v-btn color="primary" dark class="mb-2 ml-3" v-on="on">New Item</v-btn>
			            <v-text-field
					        v-model="search"
					        append-icon="search"
					        label="Search"
					        single-line
					        hide-details
					      ></v-text-field>
			          </template>
			          <v-card>
			            <v-card-title>
			              <span class="headline">{{ formTitle }}</span>
			            </v-card-title>

			            <v-card-text>
			              <v-container>
			                <v-row>
			                  <v-col cols="12" sm="6" md="4">
			                    <v-text-field v-model="editedItem.asset_name" label="Nama"></v-text-field>
			                  </v-col>
			                  <v-col cols="12" sm="6" md="4">
			                    <v-text-field v-model="editedItem.asset_brand" label="Merk"></v-text-field>
			                  </v-col>
			                  <v-col cols="12" sm="6" md="4">
			                    <v-autocomplete v-model="editedItem.group_id" @change="setCategoriesEdit(editedItem.group_id)" label="Group" :items="autocompleteData"
								    ></v-autocomplete>
			                  </v-col>
			                  <v-col cols="12" sm="6" md="4">
			                    <v-autocomplete v-model="editedItem.assettype_id" label="Tipe" :items="editCategories"
								    ></v-autocomplete>
			                  </v-col>
			                  <v-col cols="12" sm="6" md="4">
			                    <v-autocomplete v-model="editedItem.room_id" label="Ruang" :items="autocompleteRoom"
								    ></v-autocomplete>
			                  </v-col>
			                  <v-col cols="12" sm="6" md="4">
			                    <v-text-field v-model="editedItem.asset_inventory_code" label="Kode Inventaris"></v-text-field>
			                  </v-col>
			                  <v-col cols="12" sm="6" md="4">
			                    <v-text-field v-model="editedItem.asset_inventory_numb" label="No Inventaris"></v-text-field>
			                  </v-col>
			                  <v-col cols="12" sm="6" md="4">
			                    <v-text-field v-model="editedItem.asset_serial_numb" label="Serial Number"></v-text-field>
			                  </v-col>
			                  <v-col cols="12" sm="6" md="4">
			                    
			                  </v-col>
			                  <v-col cols="12" sm="6" md="4">
			                  	<v-textarea label="Keterangan"
						          v-model="editedItem.asset_description"
						        ></v-textarea>
			                  </v-col>
			                </v-row>
			              </v-container>
			            </v-card-text>

			            <v-card-actions>
			              <div class="flex-grow-1"></div>
			              <v-btn color="blue darken-1" text @click="editModalClose">Cancel</v-btn>
			              <v-btn color="blue darken-1" text @click="saveAsset" v-if="editedIndex > -1">Save</v-btn>
			              <v-btn color="blue darken-1" text @click="addAsset" v-else>Add</v-btn>
			            </v-card-actions>
			          </v-card>
			        </v-dialog>
			      </v-toolbar>
			    </template>
			    <template v-slot:item.action="{ item }">
			      [<v-icon
			        small
			        @click="detailItem(item)"
			      >
			        mdi-eye
			      </v-icon>]
			      [<v-icon
			        small
			        @click="editItem(item)"
			      >
			        mdi-pencil
			      </v-icon>]
			      [<v-icon
			        small
			        @click="deleteItem(item)"
			      >
			        delete
			      </v-icon>]
			      [<v-icon
			        small
			        @click="moveItem(item)"
			      >
			        mdi-folder-move
			      </v-icon>]
			    </template><!--
			    <template v-slot:no-data>
			      <v-btn color="primary" @click="initialize">Reset</v-btn>
			    </template>-->
			  </v-data-table>
		</v-col>
	</v-row>
	<!-- ============================ Pindah barang ========================================== -->
	<v-dialog v-model="moveModal">
		<v-card>
			<v-card-title>
			    <span class="headline">Catatan Perpindahan</span>
			</v-card-title>

			<v-card-text>
			    <v-container>
			        <v-row>
			        	<v-col cols="12" sm="12" md="8">
			        		<v-container>
			        			<v-row>
						            <v-col cols="12" sm="6" md="4">
						                <v-text-field v-model="editedMoveItem.asset_name" label="Nama Barang" readonly></v-text-field>
						            </v-col>
						            <v-col cols="12" sm="6" md="4">
						                <v-text-field v-model="editedMoveItem.asset_inventory_code" label="Kode Inventaris" readonly></v-text-field>
						            </v-col>
						            <v-col cols="12" sm="6" md="4">
						                <v-text-field v-model="editedMoveItem.asset_inventory_numb" label="No Inventaris" readonly></v-text-field>
						            </v-col>
						            <v-col cols="12" sm="6" md="4">
						                <v-text-field v-model="editedMoveItem.asset_serial_numb" label="Serial Number" readonly></v-text-field>
						            </v-col>
						            <v-col cols="12" sm="6" md="4">
						                <v-autocomplete v-model="editedMoveItem.mover_id" label="Pemindah" :items="autocompleteUser"
												    ></v-autocomplete>
						            </v-col>
						            <v-col cols="12" sm="6" md="4">
						            	<v-datetime-picker label="Tanggal pindah" v-model="editedMoveItem.move_at"> </v-datetime-picker><!--
									    <v-menu
									        v-model="moveDateTimeMenu"
									        :close-on-content-click="false"
									        :nudge-right="40"
									        transition="scale-transition"
									        offset-y
									        min-width="290px"
									    >
									        <template v-slot:activator="{ on }">
									            <v-text-field
										            v-model="editedMoveItem.move_at"
										            label="Tanggal Dipindah"
										            readonly
										            v-on="on"
										        ></v-text-field>
										    </template>
									        <v-date-picker v-model="editedMoveItem.move_at" @input="moveDateMenu = false"></v-date-picker>
									    </v-menu>-->
									</v-col>
						            <v-col cols="12" sm="6" md="4">
						                <v-autocomplete v-model="editedMoveItem.room_id" label="Dipindah di" :items="autocompleteRoom"
												    ></v-autocomplete>
						            </v-col>
						            <v-col cols="12" sm="6" md="6">
						                <v-text-field v-model="editedMoveItem.move_description" label="Keterangan"></v-text-field>
						            </v-col>
						        </v-row>
						    </v-container>
						</v-col>
						<v-col cols="12" sm="12" md="4">
			        		<v-card flat>
					          <v-card-text>
					          	<v-list-item three-line v-for="move in editedMoveItem.moves" :key="move.id">
						          	<v-list-item-content>
								        <v-list-item-title>ke {{move.room_name}} oleh {{move.mover_name}} <span></span></v-list-item-title>
								        <v-list-item-subtitle><span class="caption">tanggal {{move.move_at}} ({{move.move_description}}) dicatat oleh {{move.created_by}} pada {{move.created_at}}</span></v-list-item-subtitle>
								    </v-list-item-content>
					          	</v-list-item>
					           </v-card-text>
					        </v-card>
					    </v-col>
			        </v-row>
			    </v-container>
			</v-card-text>

			<v-card-actions>
			    <div class="flex-grow-1"></div>
			    <v-btn color="blue darken-1" text @click="closeMoveModal">Cancel</v-btn>
			    <v-btn color="blue darken-1" text @click="saveAssetMove">Pindah</v-btn>
			</v-card-actions>
		</v-card>
	</v-dialog>
	<!-- ============================ Pindah barang ========================================== -->
	<v-dialog v-model="detailModal">
		<v-card>
		    <v-tabs
		      v-model="detailTab"
		      background-color="indigo"
		      centered
		      dark
		      icons-and-text
		    >
		      <v-tabs-slider></v-tabs-slider>

		      <v-tab href="#tab-1">
		        Detail
		        <v-icon>mdi-details</v-icon>
		      </v-tab>

			  <v-tab href="#tab-2">
		        Penerimaan
		        <v-icon>mdi-hand-left</v-icon>
		      </v-tab>

		      <v-tab href="#tab-3">
		        Perpindahan
		        <v-icon>mdi-folder-move</v-icon>
		      </v-tab>

		      <v-tab href="#tab-4">
		        Kondisi
		        <v-icon>mdi-bottle-tonic-plus</v-icon>
		      </v-tab>
		    </v-tabs>

		    <v-tabs-items v-model="detailTab">
		      <v-tab-item value="tab-1">
		        <v-card flat>
		          <v-card-text>
		          	<table class="mx-auto">
		          		<tr>
		          			<td>Nama</td><td>:</td><td>{{assetDetail.asset.asset_name}}</td>
		          		</tr>
		          		<tr>
		          			<td>Merk</td><td>:</td><td>{{assetDetail.asset.asset_brand}}</td>
		          		</tr>
		          		<tr>
		          			<td>Grup</td><td>:</td><td>{{assetDetail.asset.group_name}}</td>
		          		</tr>
		          		<tr>
		          			<td>Tipe</td><td>:</td><td>{{assetDetail.asset.assettype_name}}</td>
		          		</tr>
		          		<tr>
		          			<td>Satuan</td><td>:</td><td>{{assetDetail.asset.assettype_unit}}</td>
		          		</tr>
		          		<tr>
		          			<td>Kode Inventaris</td><td>:</td><td>{{assetDetail.asset.asset_inventory_code}}</td>
		          		</tr>
		          		<tr>
		          			<td>Keterangan</td><td>:</td><td>{{assetDetail.asset.asset_description}}</td>
		          		</tr>
		          		<tr>
		          			<td>Ruang</td><td>:</td><td>{{assetDetail.asset.room_name}} ( {{assetDetail.asset.room_alias}} )</td>
		          		</tr>
		          		<tr>
		          			<td>Didata oleh</td><td>:</td><td><strong>{{assetDetail.asset.created_by}}</strong> pada {{assetDetail.asset.created_at}}</td>
		          		</tr>
		          		<tr>
		          			<td>Update data oleh</td><td>:</td><td><strong>{{assetDetail.asset.updated_by}}</strong> pada {{assetDetail.asset.updated_at}}</td>
		          		</tr>
		          	</table>
		          </v-card-text>
		        </v-card>
		      </v-tab-item>
		      <v-tab-item value="tab-2">
		        <v-card flat>
		          <v-card-text>
		          	<div v-if="assetDetail.receive">
			          	<table class="mx-auto">
			          		<tr>
			          			<td>Pengirim</td><td>:</td><td>{{assetDetail.receive.receive_sender_identity}}</td>
			          		</tr>
			          		<tr>
			          			<td>Tanggal Pengiriman</td><td>:</td><td>{{assetDetail.receive.receive_bill_date}}</td>
			          		</tr>
			          		<tr>
			          			<td>Nomor Pengiriman</td><td>:</td><td>{{assetDetail.receive.receive_bill_number}}</td>
			          		</tr>
			          		<tr>
			          			<td>Diterima tanggal</td><td>:</td><td>{{assetDetail.receive.receive_at}}</td>
			          		</tr>
			          		<tr>
			          			<td>Oleh</td><td>:</td><td>{{assetDetail.receive.receiver_name}}</td>
			          		</tr>
			          		<tr>
			          			<td>Didata oleh</td><td>:</td><td>{{assetDetail.receive.created_by}}</td>
			          		</tr>
			          		<tr>
			          			<td>Pada tanggal</td><td>:</td><td>{{assetDetail.receive.created_at}}</td>
			          		</tr>
			          	</table>
		          	</div>
		          	<div v-else>
		          		Tidak ada data penerimaan
		          	</div>
		          </v-card-text>
		        </v-card>
		      </v-tab-item>
		      <v-tab-item value="tab-3">
		        <v-card flat>
		          <v-card-text>
		          	<v-list-item three-line v-for="move in assetDetail.moves" :key="move.id">
			          	<v-list-item-content>
					        <v-list-item-title>ke {{move.room_name}} oleh {{move.mover_name}}</v-list-item-title>
								        <v-list-item-subtitle><span class="caption">tanggal {{move.move_at}} ({{move.move_description}}) dicatat oleh {{move.created_by}} pada {{move.created_at}}</span></v-list-item-subtitle>
					    </v-list-item-content>
		          	</v-list-item>
		           </v-card-text>
		        </v-card>
		      </v-tab-item>
		      <v-tab-item value="tab-4">
		        <v-card flat>
		          <v-card-text>ini kondisi</v-card-text>
		        </v-card>
		      </v-tab-item>
		    </v-tabs-items>
		    <v-card-actions>
			    <div class="flex-grow-1"></div>
			    <v-btn color="blue darken-1" text @click="closeDetailModal">OK</v-btn>
			</v-card-actions>
		  </v-card>
	</v-dialog>
</div>
</template>
<script>
export default{
	data(){
		return{
			show_search: true,
			has_search: false,
			valid: false,
			searchCategories: [],
			editCategories: [],
			autocompleteData: [
				{value:"0", text:"Belum ada data", children: []}
			],
			autocompleteRoom: [
				{value:"0", text:"Belum ada data"}
			],
			autocompleteUser: [],
			search: '',
			picked_group: 0,
			picked_category: 0,
			assets: [],
			importModal: false,
			editModal: false,
			assetFile: null,
			headers:[
				{ text: 'Nama', align: 'left', value: 'asset_name' },
		        { text: 'Merk', value: 'asset_brand' },
		    //    { text: 'Grup', value: 'group_name' },
		    //    { text: 'Tipe', value: 'assettype_name' },
		    //    { text: 'Satuan', value: 'assettype_unit' },
		        { text: 'Ruang', value: 'room_name' },
		        { text: 'Kode', value: 'asset_inventory_code' },
		        { text: 'Nomor', value: 'asset_inventory_numb' },
		        { text: 'SN', value: 'asset_serial_numb' },
		        { text: 'Aksi', value: 'action', sortable: false }
			],
			editedItem: {},
			editedIndex: -1,

			//move data
			moveModal: false,
			editedMoveItem: {},
			//moveDateMenu: false,

			//detail data
			detailModal: false,
			detailTab: null,
			assetDetail: {
				asset: {},
				receive: {},
				conditions: [],
				moves: []
			}
		}
	},
	mounted(){
		this.getAutocomplets();
	},
	methods: {
		getAutocomplets: function(){
			axios.get(this.$store.state.apiUrl + 'group/assettypeAutocomplete').then(response=>{
				this.autocompleteData = response.data.autocompletes;
				axios.get(this.$store.state.apiUrl + 'room/autocomplete').then(response=>{
					this.autocompleteRoom = response.data.rooms;
					axios.get(this.$store.state.apiUrl + 'user/autocomplete').then(response=>{
						this.autocompleteUser = response.data.users;
					});
				});
			});
		},
		setCategoriesSearch: function(groupId){
			var groupIndex = this.autocompleteData.map(e=>e.value).indexOf(groupId);
			this.searchCategories = this.autocompleteData[groupIndex].children;
			this.editCategories = _.cloneDeep(this.searchCategories);
		},
		setCategoriesEdit: function(groupId){
			var groupIndex = this.autocompleteData.map(e=>e.value).indexOf(groupId);
			this.editCategories = this.autocompleteData[groupIndex].children;
		},
		getAssets: function(){
			if(this.picked_group && this.picked_category){
				axios.post(this.$store.state.apiUrl + 'asset/filter',{
					assettype_id: this.picked_category
				}).then(response=>{
					this.has_search = true;
					this.assets = response.data.assets;
				});
			}
		},
		addAsset: function(){
			axios.post(this.$store.state.apiUrl + 'asset',{
				editedItem: this.editedItem
			}).then(response=>{
				this.$swal("Good job!", response.data.message, "success");
				this.getAssets();
				this.editModalClose();
			});
		},
		saveAsset: function(){
			axios.patch(this.$store.state.apiUrl + 'asset/' + this.editedItem.id,{
				editedItem: this.editedItem
			}).then(response=>{
				this.$swal("Good job!", response.data.message, "success");
				this.getAssets();
				this.editModalClose();
			});
		},
		importAsset: function(){
			if(this.assetFile){
				let formData = new FormData();
		        formData.append('file', this.assetFile);

		        axios.post(this.$store.state.apiUrl + 'asset/import',
		            formData,
		            {
		                headers: {
		                    'Content-Type': 'multipart/form-data'
		                }
		            }
		        ).then(response=>{
		        	this.getAutocomplets();
		        	this.$swal("Good job!", response.data.message, "success");
		        	this.assetFile = null;
		        	this.importModal = false;
		        });
			}
		},

		editModalClose: function() {
	        this.editModal = false;
	        this.editedItem = {};
	        this.editedIndex = -1;
	    },

	    editItem: function(item){
	    	this.editedIndex = this.assets.indexOf(item);
	        this.editedItem = Object.assign({}, item);
	        this.editModal = true;
	    },

	    deleteItem: function(item){
	    	if(confirm("Yakin mau menghapus " + item.asset_name + " ini?")){
	    		axios.delete(this.$store.state.apiUrl + 'asset/' + item.id).then(response=>{
	    			this.$swal("Good job!", response.data.message, "success");
					this.getAssets();
	    		});
	    	}
	    },
	    //move item
	    moveItem: function(item){
	    	this.editedMoveItem = Object.assign({}, item);
	    	axios.get(this.$store.state.apiUrl + 'move/show/' + item.id).then(response=>{
	    		this.editedMoveItem.moves = response.data.moves;
	    		this.moveModal = true;
	    	});
	    },
	    closeMoveModal: function(){
	    	this.editedMoveItem = {};
	    	this.moveModal = false;
	    },
	    saveAssetMove: function(){
	    	axios.post(this.$store.state.apiUrl + 'move',{
	    		editedItem: this.editedMoveItem	
	    	}).then(response=>{
	    		this.$swal("Good job!", response.data.message, "success");
	    		this.getAssets();
				this.closeMoveModal();
	    	});
	    },

	    //detail item
	    detailItem: function(item){
	    	axios.get(this.$store.state.apiUrl + 'asset/detail/' + item.id).then(response=>{
	    		this.assetDetail = response.data.asset_detail;
	    		this.detailModal = true;
	    	});
	    },
	    closeDetailModal: function(){
	    	this.detailModal = false;
	    }
	},
	computed: {
		formTitle: function(){
			if(this.editedIndex > -1){
				return "Edit Asset";
			}
			else{
				return "Tambah Asset Baru";
			}
		}
	}
}
</script>