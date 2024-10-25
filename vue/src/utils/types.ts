export type TableInformation = {
  Field: string
  Type: string
  Null: 'YES' | 'NO'
  Key: string
  Default: string | null
  Extra: string
}

export type SelectOption = {
  value: string | number
  label: string
}
