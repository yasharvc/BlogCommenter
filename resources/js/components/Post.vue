<template>
  <div class="container">
    <div class="row">
      <div class="card mb-12">
        <a href="#!"
          ><img
            class="card-img-top"
            src="https://dummyimage.com/850x350/dee2e6/6c757d.jpg"
            alt="..."
        /></a>
        <div class="card-body">
          <div class="small text-muted">January 1, 2021</div>
          <h2 class="card-title">Featured Post Title</h2>
          <p class="card-text">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis
            aliquid atque, nulla? Quos cum ex quis soluta, a laboriosam. Dicta
            expedita corporis animi vero voluptate voluptatibus possimus, veniam
            magni quis!
          </p>
          <a class="btn btn-primary" href="#!">Read more →</a>
        </div>
      </div>
    </div>
    <section>
      <h1>Comments:</h1>
      <div class="form-row">
        <div class="col-3">
          <input
            type="text"
            class="form-control"
            placeholder="Username..."
            v-model="username"
          />
        </div>
        <div class="col-9">
          <div class="input-group mb-3">
            <input
              type="text"
              class="form-control"
              placeholder="Comment..."
              aria-label="Comment..."
              aria-describedby="basic-addon2"
              v-model="comment"
            />
            <div class="input-group-append">
              <button
                class="btn btn-outline-secondary"
                type="button"
                :disabled="!isValid || inProgress"
                @click="addComment"
              >
                Add Comment<i
                  v-if="inProgress"
                  class="fa fa-spin fa-spinner"
                ></i>
              </button>
            </div>
          </div>
        </div>
      </div>
      <comment
        v-for="node in loadedComments"
        :key="node.id"
        :node="node"
        @newReplyAdded="newReplyAdded"
      />
      <div class="container my-3 bg-light">
        <div class="col-md-12 text-center">
          <button @click="nextPage" class="btn btn-secondary">
            Load <span v-if="pagination.current_page > 0">more</span> comments
          </button>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
import comment from "./commnet.vue";
export default {
  components: {
    comment,
  },
  data() {
    return {
      username: "",
      comment: "",
      loadedComments: [],
      inProgress: false,
      pagination: {
        current_page: 0,
        per_page: 10,
        last_page: 1,
        next_page_url: null,
      },
    };
  },
  mounted() {
    this.nextPage();
  },
  computed: {
    isValid() {
      return this.username.length > 0 && this.comment.length > 0;
    },
  },
  methods: {
    resetPaging() {
      this.pagination.current_page = 0;
      this.pagination.per_page = 10;
      this.pagination.last_page = 1;
      this.pagination.next_page_url = null;
    },
    nextPage() {
      if (this.pagination.current_page < this.pagination.last_page) {
        this.pagination.current_page++;
        let url = this.pagination.next_page_url;
        //First time or retry to get latest page
        if (this.pagination.next_page_url == null) {
          url = "/api/comments?page=" + this.current_page;
        }
        axios.get(url).then((resp) => {
          this.pagination.current_page = resp.data.current_page;
          this.pagination.per_page = resp.data.per_page;
          this.pagination.last_page = resp.data.last_page;
          this.pagination.next_page_url = resp.data.next_page_url;
          this.concatComments(resp.data.data);
        });
      } else {
        alert("All comments already loaded");
      }
    },
    concatComments(comments) {
      this.makeTree(comments);
    },
    makeTree(comments) {
      comments.forEach((e) => {
        //If comment is a reply then path_to_parent has at least one comma(,)
        if (e.path_to_parent.indexOf(",") > -1) {
          e.children = [];
          var parent = this.getParent(e.path_to_parent);
          parent.children.push(e);
        } else {
          e.children = [];
          this.loadedComments.push(e);
        }
      });
      //return res;
    },
    getParent(path) {
      var arr = path.split(",").slice(0, -1);
      var res = null;
      arr.forEach((id) => {
        if (res == null)
          res = this.loadedComments.find((o) => o.id == parseInt(id));
        else res = res.children.find((o) => o.id == parseInt(id));
      });
      return res;
    },
    addComment() {
      this.inProgress = true;
      if (this.isValid) {
        axios
          .post("/api/comment/add", {
            username: this.username,
            comment: this.comment,
          })
          .then((res) => {
            if (res.data.error == false) {
              this.loadedComments = [];
              this.resetPaging();
              this.nextPage();
              this.inProgress = false;
              this.comment = "";
              this.username = "";
            }
          });
      }
    },
    newReplyAdded(id, comment) {
      var parent = this.getParent(comment.path_to_parent);
      if (parent.children.length == 0) {
        parent.children.push(comment);
      } else {
        parent.children.unshift(comment);
      }
    },
  },
};
</script>