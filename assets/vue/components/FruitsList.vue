<template>
  <h1>Fruits</h1>
  <div>
    <input
      type="text"
      placeholder="Search by name"
      v-model="fruitname"
      v-on:input="searching"
      :style="{
        height: '35px',
        width: '260px',
        border: '1px solid skyblue',
        'border-radius': '5px',
        'padding-left': '10px',
      }"
    />
    <input
      type="text"
      placeholder="Search by family"
      class="search2"
      v-model="familyname"
      v-on:input="searching"
      :style="{
        height: '35px',
        width: '260px',
        border: '1px solid skyblue',
        'border-radius': '5px',
        'padding-left': '10px',
        'margin-left': '40px',
      }"
    />
    <div
      class="container"
      :style="{
        'margin-top': '50px',
      }"
    >
      <table
        :style="{
          width: '600px',
          border: '1px solid powderblue',
          'border-radius': '7px',
          padding: '16px 16px 0px',
        }"
      >
        <tr class="tr1">
          <th>Name</th>
          <th>Family</th>
          <th>Genus</th>
          <th>Status</th>
        </tr>
        <tr v-for="item in restaurants" :key="item.id" class="tr1">
          <td>
            <p
              :style="{
                'text-align': 'center',
              }"
            >
              {{ item.name }}
            </p>
          </td>
          <td>
            <p
              :style="{
                'text-align': 'center',
              }"
            >
              {{ item?.family }}
            </p>
          </td>
          <td>
            <p
              :style="{
                'text-align': 'center',
              }"
            >
              {{ item?.genus }}
            </p>
          </td>
          <td>
            <button
              :style="{
                'background-color': 'white',
                border: '0px',
              }"
              v-if="!item?.isFavourite"
              v-on:click="addToFav(item?.id)"
            >
              <img
                src="https://pixlok.com/wp-content/uploads/2021/03/Add-Icon-PNG-Image.jpg"
                alt="add"
                :style="{
                  height: '25px',
                  width: '28px',
                  'background-color': '#fff',
                  'margin-top': '5px',
                  'margin-left': '100px',
                }"
              />
            </button>
          </td>
        </tr>
      </table>
    </div>
    <div
      :style="{
        display: 'flex',
        'flex-direction': 'row',
        'margin-top': '50px',
      }"
    >
      <button
        :style="{
          'background-color': 'white',
          border: '0px',
        }"
        v-on:click="decrement"
      >
        <img
          src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQCCHX3uHsxczh1dZnJxieTZAq0d6v4inYo-w&usqp=CAU"
          alt="previous page"
          :style="{
            height: '40px',
            width: '40px',
            'margin-right': '10px',
          }"
        />
      </button>
      <p :style="{ 'margin-left': '10px', 'margin-right': '10px' }">
        {{ page }}
      </p>
      <button
        :style="{
          'background-color': 'white',
          border: '0px',
        }"
        v-on:click="increment"
      >
        <img
          :style="{
            height: '40px',
            width: '40px',
            'margin-right': '10px',
          }"
          src="data:image/png;base64,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"
          alt="next page"
        />
      </button>
      <button
        class="bt2"
        v-on:click="goToFav"
        :style="{
          height: '30',
          width: '120',
          border: '1px solid powderblue',
          'border-radius': '10px',
          'background-color': '#fff',
          'margin-left': '60px',
        }"
      >
        Favourite Fruits
      </button>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: "FruitsList",
  data() {
    return {
      fruitname: "",
      familyname: "",
      restaurants: [],
      page: 1,
    };
  },
  methods: {
    increment() {
      if (Object.keys(this.restaurants).length > 0) {
        this.page = this.page + 1;
        this.getAllFruits();
      }
    },
    decrement() {
      if (this.page > 1) {
        this.page = this.page - 1;
        this.getAllFruits();
      }
    },
    goToFav() {
      this.$router.push({
        name: "FavoriteFruits",
      });
    },
    searching() {
      this.page = 1;
      this.getAllFruits();
    },
    async getAllFruits() {
      let result = await axios.get(
        `http://localhost:8000/api/fruits?page=${this.page}&name=${this.fruitname}&family=${this.familyname}`
      );
      this.restaurants = result?.data?.data?.fruits;
      console.log("all fruits", result?.data?.data?.fruits);
    },
    async addToFav(_id) {
      let result = await axios.post(
        `http://localhost:8000/api/make-favourite/${_id}`
      );
      console.log(result, "add to fav");
      this.getAllFruits();
    },
  },
  mounted() {
    this.getAllFruits();
  },
};
</script>
