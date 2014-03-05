---
layout: post
title: 经典算法之二分查找
categories: [ code ]
tags: [ c, search ]
---


### binary search in c

{% highlight c linenos %}

    #include<stdio.h>
    
    int search(int needle, int *haystack, int length)
    {
        int low = 0;
        int high = length-1;
        int mid = (low+high)/2;
    
        if(needle<haystack[low] || needle>haystack[high]){
            return -1;
        }
        while(low<=high){
            if(haystack[mid]>needle){
                high = mid-1;
            }else if(haystack[mid]<needle){
                low = mid+1;
            }else{
                return mid;
            }
            mid = (low+high)/2;
        }
        return -1;
    }
    
    int main()
    {
        int a[] = {0, 1, 2, 3, 6, 8, 12, 13, 15, 20};
        char rs[10];
        printf("input the needle: ");
        gets(rs);
        int ri = atoi(rs);
        int i = search(ri, a, sizeof(a)/sizeof(a[0]));
        printf("%d\n", i);
        return 1;
    }

{% endhighlight %}

