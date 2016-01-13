SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

CREATE TABLE [dbo].[people](
	[person_id] [int] IDENTITY(1,1) NOT NULL,
	[first_name] [varchar](max) NULL,
	[last_name] [varchar](max) NULL,
	[phone_number] [varchar](max) NULL,
	[email] [varchar](max) NULL,
	[address_1] [varchar](max) NULL,
	[address_2] [varchar](max) NULL,
	[city] [varchar](max) NULL,
	[state] [varchar](max) NULL,
	[zip] [varchar](max) NULL,
	[country] [varchar](max) NULL,
	[comments] [text] NULL,
	[create_dt] [datetime] NULL,
 CONSTRAINT [PK_people] PRIMARY KEY CLUSTERED 
(
	[person_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO

SET ANSI_PADDING OFF
GO