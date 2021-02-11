<template>
  <div class="components">

    <ul class="list-group" id="example-1">
      <li class="list-group-item" v-for="(item, index) in items" :key="index">
        {{ item.name }}
        {{ index }}
        <button @click="deleteRow(index)" class="btn btn-danger btn-xs">X</button>
      </li>
    </ul>
    <pre>{{ items }}</pre>
  </div>
</template>

<script>
  export default {
    name: 'single-dim',
    data () {
      return {
        items: [
          { name: 'Peter', 'age': '23' },
          { name: 'Andrew', 'age': '28' },
          { name: 'Raja', 'age': '98' }
        ]
      }
    },
    methods: {
      deleteRow (index) {
        this.items.splice(index, 1)
        console.log(index)
      }
    }
  }
</script>
