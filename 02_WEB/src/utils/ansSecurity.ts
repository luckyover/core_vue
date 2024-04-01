import ansCommon from './ansCommon'
const base64 = (() => {
  const _keyStr = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/='
  const _utf8_encode = (string: string) => {
    var utf8Text = ''
    string = string.replace(/\r\n/g, '\n')

    for (var n = 0; n < string.length; n++) {
      var c = string.charCodeAt(n)

      if (c < 128) {
        utf8Text += String.fromCharCode(c)
      } else if (c > 127 && c < 2048) {
        utf8Text += String.fromCharCode((c >> 6) | 192)
        utf8Text += String.fromCharCode((c & 63) | 128)
      } else {
        utf8Text += String.fromCharCode((c >> 12) | 224)
        utf8Text += String.fromCharCode(((c >> 6) & 63) | 128)
        utf8Text += String.fromCharCode((c & 63) | 128)
      }
    }
    return utf8Text
  }
  const _utf8_decode = (utf8Text: string) => {
    var string = ''
    var i = 0
    var c, c1, c2, c3
    c = c1 = c2 = 0

    while (i < utf8Text.length) {
      c = utf8Text.charCodeAt(i)

      if (c < 128) {
        string += String.fromCharCode(c)
        i++
      } else if (c > 191 && c < 224) {
        c2 = utf8Text.charCodeAt(i + 1)
        string += String.fromCharCode(((c & 31) << 6) | (c2 & 63))
        i += 2
      } else {
        c2 = utf8Text.charCodeAt(i + 1)
        c3 = utf8Text.charCodeAt(i + 2)
        string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63))
        i += 3
      }
    }
    return string
  }
  const encode = (input: string) => {
    var output = ''
    var chr1, chr2, chr3, enc1, enc2, enc3, enc4
    var i = 0

    input = _utf8_encode(input)

    while (i < input.length) {
      chr1 = input.charCodeAt(i++)
      chr2 = input.charCodeAt(i++)
      chr3 = input.charCodeAt(i++)

      enc1 = chr1 >> 2
      enc2 = ((chr1 & 3) << 4) | (chr2 >> 4)
      enc3 = ((chr2 & 15) << 2) | (chr3 >> 6)
      enc4 = chr3 & 63

      if (isNaN(chr2)) {
        enc3 = enc4 = 64
      } else if (isNaN(chr3)) {
        enc4 = 64
      }

      output =
        output +
        _keyStr.charAt(enc1) +
        _keyStr.charAt(enc2) +
        _keyStr.charAt(enc3) +
        _keyStr.charAt(enc4)
    }
    return output
  }
  const decode = (input: string) => {
    var output = ''
    var chr1, chr2, chr3
    var enc1, enc2, enc3, enc4
    var i = 0

    input = input.replace(/[^A-Za-z0-9\+\/\=]/g, '')
    while (i < input.length) {
      enc1 = _keyStr.indexOf(input.charAt(i++))
      enc2 = _keyStr.indexOf(input.charAt(i++))
      enc3 = _keyStr.indexOf(input.charAt(i++))
      enc4 = _keyStr.indexOf(input.charAt(i++))

      chr1 = (enc1 << 2) | (enc2 >> 4)
      chr2 = ((enc2 & 15) << 4) | (enc3 >> 2)
      chr3 = ((enc3 & 3) << 6) | enc4

      output = output + String.fromCharCode(chr1)

      if (enc3 != 64) {
        output = output + String.fromCharCode(chr2)
      }

      if (enc4 != 64) {
        output = output + String.fromCharCode(chr3)
      }
    }
    output = _utf8_decode(output)
    return output
  }
  return {
    encode: encode,
    decode: decode
  }
})()
const ansSecurity = {
  encodeParams: (params?: IAnsDynamic | null) => {
    try {
      if (params === undefined || params === null || Object.keys(params).length === 0) {
        return ''
      }
      let output = base64.encode(JSON.stringify(params))
      let endPos = 0
      for (endPos = output.length; endPos > 0; endPos--) {
        if (output[endPos - 1] !== '=') {
          break
        }
      }
      const numberPaddingChars = output.length - endPos
      output = output.replace(/\+/g, '-')
      output = output.replace(/\//g, '_')
      output = output.substring(0, endPos)
      output = output + numberPaddingChars

      return output
    } catch (e) {
      return ''
    }
  },
  decodeParams: (params?: string | null) => {
    try {
      if (params === undefined || params === null || params === '') {
        return {}
      }
      var numberPadding = parseInt(params.substring(params.length - 1))
      params = params.substring(0, params.length - 1)
      params = params.replace(/-/g, '+')
      params = params.replace(/_/g, '/')
      for (var j = 0; j < numberPadding; j++) {
        params = params + '='
      }
      params = params.replace(/[^A-Za-z0-9+/=]/g, '')
      params = atob(params)
      return JSON.parse(params)
    } catch (e) {
      return {}
    }
  },
  generatePassword(length?: number, rules?: Array<{ chars: string; min: number }>) {
    if (!length || length == undefined) {
      length = 12
    }
    if (!rules || rules == undefined) {
      rules = [
        { chars: 'abcdefghijklmnopqrstuvwxyz', min: 3 },
        { chars: 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', min: 2 },
        { chars: '0123456789', min: 2 },
        { chars: '!@#$&*?|%+-_./:;=()[]{}', min: 1 }
      ]
    }
    var allChars = '',
      allMin = 0
    rules.forEach(function (rule) {
      allChars += rule.chars
      allMin += rule.min
    })
    if (length < allMin) {
      length = allMin
    }
    rules.push({ chars: allChars, min: length - allMin })
    var passwd = ''
    rules.forEach(function (rule) {
      if (rule.min > 0) {
        passwd += ansCommon.shuffleString(rule.chars, rule.min)
      }
    })
    return ansCommon.shuffleString(passwd)
  }
}

export default ansSecurity
