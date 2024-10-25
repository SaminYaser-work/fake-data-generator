import type { SelectOption } from './types'

const INTS = ['tinyint', 'smallint', 'mediumint', 'int', 'bigint']
const FLOATS = ['decimal', 'numeric', 'float', 'double']
const BOOLEANS = ['boolean']
const DATETIMES = ['datetime', 'timestamp']
const STRINGS = ['varchar', 'tinytext', 'text', 'mediumtext', 'longtext']

function check(values: Array<string>, type: string) {
  for (const value of values) {
    if (type.startsWith(value)) {
      return true
    }
  }

  return false
}

export function getType(type: string) {
  if (check(INTS, type)) {
    return 'int'
  }

  if (check(FLOATS, type)) {
    return 'float'
  }

  if (check(BOOLEANS, type)) {
    return 'bool'
  }

  if (check(DATETIMES, type)) {
    return 'datetime'
  }

  if (check(STRINGS, type)) {
    return 'string'
  }

  if (type.startsWith('year')) {
    return 'year'
  }

  if (type.startsWith('date')) {
    return 'date'
  }

  if (type.startsWith('time')) {
    return 'time'
  }

  return null
}

export function getOptions(type: string): SelectOption[] | null {
  switch (type) {
    case 'int':
      return [
        {
          value: 'int',
          label: 'Integer',
        },
        {
          value: 'ipv4-num',
          label: 'IPV4',
        },
      ]
    case 'float':
      return [
        {
          value: 'float',
          label: 'Float',
        },
      ]
    case 'string':
      return [
        {
          value: 'text',
          label: 'Text',
        },
        {
          value: 'html',
          label: 'HTML',
        },
        {
          value: 'email',
          label: 'Email',
        },
        {
          value: 'username',
          label: 'Username',
        },
        {
          value: 'password',
          label: 'Password',
        },
        {
          value: 'url',
          label: 'URL',
        },
        {
          value: 'slug',
          label: 'Slug',
        },
        {
          value: 'ipv4',
          label: 'IPV4',
        },
        {
          value: 'ipv6',
          label: 'IPV6',
        },
        {
          value: 'mac',
          label: 'MAC Address',
        },
        {
          value: 'ua',
          label: 'User Agent',
        },
        {
          value: 'ccn',
          label: 'Credit Card Number',
        },
        {
          value: 'color',
          label: 'Color',
        },
        {
          value: 'uuid',
          label: 'UUID',
        },
        {
          value: 'country',
          label: 'Country Code',
        },
        {
          value: 'currency',
          label: 'Currency Code',
        },
        {
          value: 'lang',
          label: 'Language Code',
        },
      ]
    case 'bool':
      return [
        {
          value: 'bool',
          label: 'Boolean',
        },
      ]
    case 'year':
      return [
        {
          value: 'year',
          label: 'Year',
        },
      ]
    case 'date':
      return [
        {
          value: 'date',
          label: 'Date',
        },
      ]
    case 'time':
      return [
        {
          value: 'time',
          label: 'Time',
        },
      ]
    case 'datetime':
      return [
        {
          value: 'datetime',
          label: 'Datetime',
        },
      ]
  }

  return null
}
