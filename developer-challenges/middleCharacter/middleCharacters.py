s=input()
l=len(s)
h=l/2
print s[h-(l&1==0):h+1]
