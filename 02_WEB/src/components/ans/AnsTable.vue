<script setup lang="ts">
import _ from 'lodash'

const props = withDefaults(defineProps<IAnsTableProps>(), {
  columns: () => [],
  list: () => [],
  condition: () => ({})
})

const onChangePageSize = (pagesize: number) => {
  props.condition.page_size = pagesize
  if (props.onSearch) {
    props.onSearch()
  }
}

const sortTable = (column: string, sort: string) => {
  props.condition.sort_column = column
  props.condition.sort_type = sort
  if (props.onSearch) {
    props.onSearch()
  }
}

const onSelectedRow = (item: IAnsDynamic) => {
  if (props.onSelected) {
    props.onSelected(item)
  }
}
</script>

<template>
  <AnsPaging :paging="paging" :onChangeEvent="onSearch" :onChangePageSizeEvent="onChangePageSize" />
  <div class="row">
    <div class="col-md-12">
      <AnsTwoScrollDiv>
        <table class="table ans-table table-in-popup fix-header" :class="class">
          <thead>
            <tr>
              <template v-for="(col, idx) in columns" :key="idx">
                <AnsSortColumn
                  :columnName="col.name"
                  :title="col.title"
                  :currentColumn="condition.sort_column"
                  :sortType="condition.sort_type"
                  :class="`col-${col.name} ${col.isFixColumn ? 'fix-column' : ''}`"
                  :onSort="sortTable"
                />
              </template>
            </tr>
          </thead>
          <tbody>
            <template v-for="item in list">
              <tr
                @click="
                  () => {
                    onSelectedRow(item)
                  }
                "
              >
                <template v-for="(col, idx) in columns" :key="idx">
                  <td
                    :class="`${col.class ?? ''} col-${col.name} ${
                      col.isFixColumn ? 'fix-column' : ''
                    }`"
                  >
                    <span v-if="!col.hasTooltip">{{ _.get(item, col.name, '') }}</span>
                    <AnsTooltipSpan v-else :value="_.get(item, col.name, '')" />
                  </td>
                </template>
              </tr>
            </template>
            <AnsEmptyRow :condition="condition" :list="list" :colspan="columns.length" />
          </tbody>
        </table>
      </AnsTwoScrollDiv>
    </div>
  </div>
  <AnsPaging :paging="paging" :isShowPageSize="false" :onChangePageSizeEvent="onChangePageSize" />
</template>
