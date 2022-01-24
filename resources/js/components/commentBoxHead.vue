<template>
  <div class="comment-head">
    <h6 class="comment-name">{{ node.username }}</h6>
    <span>{{ node.created_at | formatDate }}</span>
    <i class="fa fa-reply" @click="show" v-if="spacing < 2"></i>
    <b-modal 
    :id="dialogId2" 
    title="Comment Detail"
    @ok="save($event)">
      <b-card bg-variant="light">
        <b-form-group
          label-cols-lg="0"
          label-size="lg"
          label-class="font-weight-bold pt-0"
          class="mb-0"
        >
          <b-form-group
            label="Username:"
            label-for="username"
            label-cols-sm="3"
            label-align-sm="right"
          >
            <b-form-input v-model="username"></b-form-input>
          </b-form-group>
          <b-form-group
            label="Comment:"
            label-for="comment"
            label-cols-sm="3"
            label-align-sm="right"
          >
            <b-form-input v-model="comment"></b-form-input>
          </b-form-group>
          <span v-if="isValid"
            >{{ username }} says '{{ comment }}'</span>
        <span v-else class="text-danger">Comment is incomplete!</span>
        </b-form-group>
      </b-card>
    </b-modal>
  </div>
</template>
<script>
export default {
  props: ["dialogId", "node", "spacing"],
  computed: {
    dialogId2() {
      return "_" + this.dialogId;
    },
    isValid(){
        return this.username.length > 0 && this.comment.length > 0;
    }
  },
  methods: {
    show() {
      this.$bvModal.show(this.dialogId2);
    },
    save(bvModalEvt){
        bvModalEvt.preventDefault()
        if(!(this.username.length > 0 && this.comment.length > 0))
            alert('Data not valid');
        else
            this.$nextTick(() => {
                this.$bvModal.hide(this.dialogId2);
                 axios
                .post("/api/comment/add", {
                    username: this.username,
                    comment: this.comment,
                    parentId: this.dialogId
                })
            })
    }
  },
  data() {
    return {
      comment: "",
      username: "",
    };
  },
};
</script>
<style>
.comment-box .comment-head {
  background: #fcfcfc;
  padding: 10px 12px;
  border-bottom: 1px solid #e5e5e5;
  overflow: hidden;
  -webkit-border-radius: 4px 4px 0 0;
  -moz-border-radius: 4px 4px 0 0;
  border-radius: 4px 4px 0 0;
}

.comment-box .comment-head i {
  float: right;
  margin-left: 14px;
  position: relative;
  top: 2px;
  color: #a6a6a6;
  cursor: pointer;
  -webkit-transition: color 0.3s ease;
  -o-transition: color 0.3s ease;
  transition: color 0.3s ease;
}

.comment-box .comment-head i:hover {
  color: #03658c;
}
</style>