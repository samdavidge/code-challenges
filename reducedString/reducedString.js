var string = 'this is myy strringg'

for (var i = 0; i < string.length; i++) {

  if (string[i] !== string[i+1]) continue

  string = string.slice(0, i) + string.slice(i+2, string.length)

  i = -1;

}

console.log(string.length == 0 ? 'Empty string' : string)
