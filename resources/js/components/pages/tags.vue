<template>
  <div>
    <div class="content">
      <div class="container-fluid">
        <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
        <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
          <p class="_title0">
            Tags
            <Button @click="addModal=true">
              <Icon type="md-add"/>Add tag
            </Button>
          </p>

          <div class="_overflow _table_div">
            <table class="_table">
              <!-- TABLE TITLE -->
              <tr>
                <th>ID</th>
                <th>Tag name</th>
                <th>Created at</th>
                <th>Action</th>
              </tr>
              <!-- TABLE TITLE -->

              <!-- ITEMS -->
              <tr>
                <td>1</td>
                <td class="_table_name">who have experience in leather garment business</td>
                <td>people</td>
                <td>
                  <button class="_btn _action_btn edit_btn1" type="button">Edit</button>
                  <button class="_btn _action_btn make_btn1" type="button">Delete</button>
                </td>
              </tr>
              <!-- ITEMS -->
            </table>
          </div>
        </div>

        <!-- tag adding modal -->
        <Modal v-model="addModal" title="Add tag" :mask-closable="false" :closable="false">
          <p>Content of dialog</p>
          <p>Content of dialog</p>
          <p>Content of dialog</p>

          <div slot="footer">
            <Button type="default" @click="addModal=false">Close</Button>
            <Button type="primary"  @click="addTag">Add tag</Button>
          </div>
        </Modal>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      data: {
        tagName: ""
      },
      addModal: false,
      isAdding: false
    };
  },
  methods: {
    addTag() {
      if (this.data.tagName.trim()=='') return this.modalError("Tag name is required");
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