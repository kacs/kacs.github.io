---
layout: page
title: AWS Transfer Proposal
---

Transfer of Hosting to Amazon Web Services
==========================================

By Mark Wolfman

Web hosting involves several different technology layers. For the
current KACS website, these layers are all handled by different
vendors. In order to simplify this process, it is proposed to
consolidate the services into one vendor, namely Amazon Web Services
(AWS). It is anticipated that this will provide several advantages and
one disadvantage, as described below. The transition is not expected
to result in any service disruption for users of any websites
associated with the KACS. This document outlines the expected costs,
as well as details of the transition process.

**Benefits** include:

- Easier hand-off during webmaster succession
- 1 billing statement for all services
- Lower expected cost (~10% of current)
- Increased reliability
- Faster page loads
- Protection from DDOS attacks

**Drawbacks:**

- Cost is based on usage and so is difficult to predict

Cost
----

There is one fixed cost every year for domain name registation, ie.
owning "kalamazooacs.org". In AWS, this is $12/yr; currently we pay
~$15/yr.

AWS charges for hosting based on resource usage, rather than charging
a fixed rate. This means that for a low-volume website like ours, we
can expect reduced costs by switching to AWS.

According to AWS documents, the **anticipated cost** for low-volume
sites for resource usage (excluding domain registration) is $0.50/mo;
we currently pay $10/mo.

Here are the different components and the anticipated cost including
domain registration.

| Component                      | Rate                 | Expected Cost / mo |
|--------------------------------|----------------------|--------------------|
| Storage (S3)                   | $0.023 / GB          | $0.006             |
| Content Delivery (Cloudfront)  | $0.085 / GB          | $0.00085           |
| 	  	   		 | $0.010 / 10K requests| $0.005             |
| Domain Name Service (Route 53) | $0.50 / zone         | $0.50              |
| Domain Registration            | $12 / year           | $1.00              |

**Bottom line:** Unless the KACS website becomes incredibly popular,
our costs will be around $1.51 / mo, compared to our current cost of
$11.25/mo. AWS includes protection against distributed denial of
service attacks, which otherwise could trigger high resource
usage. Currently, such an attack would disable the KACS website. The
risk of enexpected popularity will be mitigated by using the AWS
budgeting and billing notification services.

Joint Great-Lakes/Central Regional Meeting
------------------------------------------

This approach could apply equally well to the [JGLCRM
website](http://jglcrm2015.com), which we are still mainting. A
decision should made regarding whether to continue, and if so whether
to transition this website to AWS as well.

Transition Process
------------------

The transition will take place in three stages. This is possible
because our current domain registrar and DNS provider do not need to
be changed right away.

1. The storage, DNS, and content delivery will
   be set up on AWS while the current system still operates.
2. Once the new storage, CDN and DNS are ready, the domain
   registration will be redirected to AWS. At this point, the website
   will be served by AWS and we will receive performance and
   reliability benefits.
3. Lastly, a domain transfer will be initiated from our old registrar
   to AWS. This may take up to 10 days, but is not anticipated to cause
   any service interruption.