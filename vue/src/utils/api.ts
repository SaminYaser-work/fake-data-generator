import type { TableInformation } from './types'

const ROOT = '/fdg/v1'

export async function getTableInfo(table: string): Promise<TableInformation[]> {
  return wp.apiFetch({
    path: ROOT + '/get-table-info',
    method: 'POST',
    data: { table },
  })
}

export async function generateData(data: FormData) {
  console.log(data)
  return wp.apiFetch({
    path: ROOT + '/generate',
    method: 'POST',
    data: Object.fromEntries(data),
  })
}
