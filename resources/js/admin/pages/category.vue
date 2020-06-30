<template>
  <div>
    <div class="content">
      <div class="container-fluid">
        <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
        <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
          <p class="_title0">
            Category
            <Button @click="addModal=true">
              <Icon type="md-add" />Add Category
            </Button>
          </p>

          <div class="_overflow _table_div">
            <table class="_table">
              <!-- TABLE TITLE -->
              <tr>
                <th>ID</th>
                <th>Category name</th>
                <th>Created at</th>
                <th>Action</th>
              </tr>
              <!-- TABLE TITLE -->

              <!-- ITEMS -->
              <tr v-for="(tag, i) in tags" :key="i" v-if="tags.length">
                <td>{{tag.id}}</td>
                <td class="_table_name">{{ tag.tagName }}</td>
                <td>{{ tag.created_at }}</td>
                <td>
                  <Button
                    class="_btn _action_btn edit_btn1"
                    type="info"
                    size="small"
                    @click="showEditModal(tag, i)"
                  >Edit</Button>
                  <Button
                    class="_btn _action_btn make_btn1"
                    type="error"
                    size="small"
                    @click="showDeletingModal(tag, i)"
                    :loading="tag.isDeleting"
                  >Delete</Button>
                </td>
              </tr>
              <!-- ITEMS -->
            </table>
          </div>
        </div>

        <!-- tag adding modal -->
        <Modal v-model="addModal" title="Add Category" :mask-closable="false" :closable="false">
          <Input v-model="data.tagName" placeholder="Add Category name" />

          <div style="margin-top:10px; margin-bottom: 10px"></div>

          <!-- upload -->
          <Upload
            type="drag"
            action="/app/upload"
            :headers="{'x-csrf-token': token, 'X-Requested-With': 'XMLHttpRequest'}"
            :on-success="handleSuccess"
            :format="['jpg','jpeg','png']"
            :max-size="2048"
            :on-format-error="handleFormatError"
            :on-error="handleError"
            :on-exceeded-size="handleMaxSize"
          >
            <div style="padding: 20px 0">
              <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
              <p>Click or drag files here to upload</p>
            </div>
          </Upload>
          <!-- endupload -->
          <div class="demo-upload-list" v-if="data.iconImage">
            <img :src="`/uploads/${data.iconImage}`" />
            <div class="demo-upload-list-cover">
              <Icon type="ios-trash-outline" @click="deleteImage"></Icon>
            </div>
          </div>

          <div slot="footer">
            <Button type="default" @click="addModal=false">Close</Button>
            <Button
              type="primary"
              @click="addTag"
              :disabled="isAdding"
              :loading="isAdding"
            >{{isAdding ? 'Adding...' : 'Add tag'}}</Button>
          </div>
        </Modal>

        <!-- tag editing modal -->
        <Modal v-model="editModal" title="Edit tag" :mask-closable="false" :closable="false">
          <Input v-model="editData.tagName" placeholder="Edit tag name" />

          <div slot="footer">
            <Button type="default" @click="editModal=false">Close</Button>
            <Button
              type="primary"
              @click="editTag"
              :disabled="isAdding"
              :loading="isAdding"
            >{{isAdding ? 'Editing...' : 'Edit tag'}}</Button>
          </div>
        </Modal>
        <!-- Delete Alert Modal  -->

        <Modal v-model="showDeleteModal" width="360">
          <p slot="header" style="color:#f60;text-align:center">
            <Icon type="ios-information-circle"></Icon>
            <span>Delete confirmation</span>
          </p>
          <div style="text-align:center">
            <p>Are you sure you want to delete this tag?</p>
          </div>
          <div slot="footer">
            <Button
              type="error"
              size="large"
              long
              :loading="isDeleting"
              :disabled="isDeleting"
              @click="deleteTag"
            >Delete</Button>
          </div>
        </Modal>
        <!--  -->
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      data: {
        iconImage: "",
        categoryName: ""
      },
      addModal: false,
      editModal: false,
      isAdding: false,
      tags: [],
      editData: {
        tagName: ""
      },
      index: -1,
      showDeleteModal: false,
      isDeleting: false,
      deleteItem: {},
      deleteIndex: -1,
      token: ""
    };
  },
  methods: {
    async addTag() {
      if (this.data.tagName.trim() == "")
        return this.error("Tag name is required");
      const res = await this.callApi("post", "/app/create_tag", this.data);
      if (res.status == 201) {
        this.tags.unshift(res.data); // tags[]에 역순으로 삽입
        this.success("Tag has been added successfully");
        this.addModal = false;
        this.data.tagName = ""; // 이후 tagName 초기화
      } else {
        if (res.status == 422) {
          if (res.data.errors.tagName) {
            this.info(res.data.errors.tagName[0]);
          }
        }
        this.swr();
      }
    },

    async editTag() {
      if (this.editData.tagName.trim() == "")
        return this.error("Tag name is required");
      const res = await this.callApi("post", "/app/edit_tags", this.editData);
      if (res.status == 200) {
        this.tags[this.index].tagName = this.editData.tagName;
        this.success("Tag has been edited successfully");
        this.editModal = false;
      } else {
        if (res.status == 422) {
          if (res.data.errors.tagName) {
            this.info(res.data.errors.tagName[0]);
          }
        } else {
          this.swr();
        }
      }
    },

    showEditModal(tag, index) {
      let obj = {
        id: tag.id,
        tagName: tag.tagName
      };
      this.editData = obj;
      this.editModal = true;
      this.index = index;
    },
    async deleteTag() {
      //   if (!confirm("Are you sure you want to delete this tag?")) return;
      //   //$set = 새로운 속성을 삽입, 현재 tag에는 isDeleting 이라는 속성이 없기때문에 this.isDeleting = true 는 안됨.
      //   this.$set(tag, "isDeleting", true);
      this.isDeleting = true;
      const res = await this.callApi(
        "post",
        "/app/delete_tags",
        this.deleteItem
      );
      if ((res.status = 200)) {
        this.tags.splice(this.deleteIndex, 1); // i(index)위치에서 1개만큼 삭제
        this.success("Tag has been successfully deleted!");
      } else {
        this.swr();
      }
      this.isDeleting = false;
      this.showDeleteModal = false;
    },
    showDeletingModal(tag, index) {
      this.deleteIndex = index;
      this.deleteItem = tag;
      this.showDeleteModal = true;
    },
    handleSuccess(res, file) {
      this.data.iconImage = res;
    },
    handleError(res, file) {
      this.$Notice.warning({
        title: "The file format is incorrect",
        desc: `${
          file.errors.file.length ? file.errors.file[0] : "Something went wrong"
        }`
      });
    },
    handleFormatError(file) {
      this.$Notice.warning({
        title: "The file format is incorrect",
        desc:
          "File format of " +
          file.name +
          " is incorrect, please select jpg or png."
      });
    },
    handleMaxSize(file) {
      this.$Notice.warning({
        title: "Exceeding file size limit",
        desc: "File  " + file.name + " is too large, no more than 2M."
      });
    },

    async deleteImage(){
        console.log(this.data.iconImage);

    }
  },

  async created() {
    this.token = window.Laravel.csrfToken;
    const res = await this.callApi("get", "/app/get_tags");
    if ((res.status = 200)) {
      this.tags = res.data;
    } else {
      this.swr();
    }
  }
  // async created() {
  //   const res = await this.callApi("POST", "/app/create_tag", {
  //     tagName: "testtag"
  //   });
  //   if (res.status == 200) {
  //     //   console.log(res);
  //   } else {
  //     console.log(res);
  //     console.log("running");
  //   }
  // }
};
</script>

<style>
</style>
